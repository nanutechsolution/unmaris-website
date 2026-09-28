import L from 'leaflet';

const BASE_PATH = '/data/wilayah';

// UNMARIS navy -> yellow ramp; neutral grey means "no data for this region".
const RAMP = ['#EEF1FB', '#B9C1E4', '#7C88C6', '#454EA0', '#1B1464'];
const NO_DATA = '#E5E7EB';

let map = null;
let dataLayer = null;
let requestToken = 0;

function formatCount(value) {
    return new Intl.NumberFormat('id-ID').format(value ?? 0);
}

/**
 * Child levels are chunked by kabupaten code (the top-level region of that
 * chunk): kabupaten is keyed by province, kecamatan by kabupaten, desa by
 * kabupaten. The browser only ever fetches the chunk it is about to draw.
 */
function geoJsonPath(level, parent) {
    if (level === 'provinsi') return `${BASE_PATH}/provinsi.geojson`;
    if (!parent) return null;

    const slug = level === 'kabupaten' ? parent : parent.slice(0, 5);
    return `${BASE_PATH}/${level}/${slug}.geojson`;
}

/** Deterministic quantile scale so colours stay stable between updates. */
function buildScale(counts) {
    const sorted = [...counts].sort((a, b) => a - b);
    if (sorted.length === 0 || sorted[sorted.length - 1] === 0) return () => null;

    const stops = RAMP.map((_, index) => sorted[Math.floor((sorted.length - 1) * index / (RAMP.length - 1))]);

    return (value) => {
        if (value == null) return null;
        let bucket = 0;
        for (let index = 0; index < stops.length; index += 1) {
            if (value >= stops[index]) bucket = index;
        }
        return RAMP[bucket];
    };
}

/** Ask the Livewire component to open the child level of this region. */
function drillDown(code, name) {
    document.dispatchEvent(new CustomEvent('student-statistics-drill', { detail: { code, name } }));
}

function initMap(container) {
    if (map) return map;

    map = L.map(container, { scrollWheelZoom: false });
    map.fitBounds([[-11.5, 94], [6.5, 142]]);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        minZoom: 4,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    // The container is inside wire:ignore, so the map survives Livewire patches.
    L.control.scale({ imperial: false }).addTo(map);
    return map;
}

function render(stats) {
    const container = document.getElementById('student-statistics-map');
    if (!container) return;

    const path = geoJsonPath(stats.level, stats.parent);
    if (!path) return;

    const activeMap = initMap(container);
    const token = ++requestToken;

    if (dataLayer) {
        activeMap.removeLayer(dataLayer);
        dataLayer = null;
    }

    const counts = (stats.rows ?? []).map((row) => row.jumlah_mahasiswa);
    const byCode = new Map((stats.rows ?? []).map((row) => [row.code, row]));
    const scale = buildScale(counts);

    fetch(path)
        .then((response) => {
            if (!response.ok) throw new Error(`geojson ${response.status}`);
            return response.json();
        })
        .then((geojson) => {
            // A newer selection replaced this request while it was in flight.
            if (token !== requestToken) return;

            dataLayer = L.geoJSON(geojson, {
                style(feature) {
                    const row = byCode.get(feature.properties.code);
                    const fill = row ? (scale(row.jumlah_mahasiswa) ?? RAMP[0]) : NO_DATA;
                    return {
                        fillColor: fill,
                        weight: 1,
                        color: '#FFFFFF',
                        opacity: 1,
                        fillOpacity: row ? 0.85 : 0.5,
                    };
                },
                onEachFeature(feature, featureLayer) {
                    const row = byCode.get(feature.properties.code);

                    // Built as DOM nodes so region names are never parsed as HTML.
                    featureLayer.bindTooltip(() => {
                        const wrapper = document.createElement('div');
                        const title = document.createElement('strong');
                        const value = document.createElement('div');

                        title.textContent = feature.properties.name;
                        value.textContent = row
                            ? `${formatCount(row.jumlah_mahasiswa)} mahasiswa`
                            : 'Tidak ada data wilayah';

                        wrapper.append(title, document.createElement('br'), value);
                        return wrapper;
                    }, { sticky: true });

                    if (stats.nextLevel) {
                        featureLayer.on('click', () => drillDown(feature.properties.code, feature.properties.name));
                        featureLayer.on('mouseover', () => featureLayer.setStyle({ weight: 3, color: '#FDE01A' }));
                        featureLayer.on('mouseout', () => featureLayer.setStyle({ weight: 1, color: '#FFFFFF' }));
                    }
                },
            });

            dataLayer.addTo(activeMap);

            if (dataLayer.getBounds().isValid()) {
                activeMap.fitBounds(dataLayer.getBounds(), { padding: [24, 24] });
            }
        })
        .catch(() => {
            // Boundaries are optional: the accessible list keeps working.
        });
}

function initialStats() {
    const element = document.getElementById('student-statistics-map');
    if (element?.dataset.stats) {
        return JSON.parse(element.dataset.stats);
    }
    return window.studentStatisticsInitial ?? {};
}

function statsFromEvent(event) {
    const detail = event.detail ?? {};
    return {
        rows: detail.rows ?? [],
        level: detail.level ?? 'provinsi',
        parent: detail.parent ?? null,
        nextLevel: detail.nextLevel ?? null,
    };
}

document.addEventListener('student-statistics-updated', (event) => render(statsFromEvent(event)));
document.addEventListener('livewire:navigated', () => render(initialStats()));

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => render(initialStats()));
} else {
    render(initialStats());
}
