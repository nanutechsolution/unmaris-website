import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

const BASE_PATH = '/data/wilayah';

// Region choropleth ramp; neutral grey means "no data for this region".
const RAMP = ['#EEF1FB', '#B9B5D8', '#7770A8', '#3B347D', '#FDE01A'];
const NO_DATA = '#E5E7EB';

// Marker bands mirror config/siakad.php `marker_bands`; the server ships them
// through data-stats so thresholds are never duplicated in front-end logic.
const DEFAULT_BANDS = [
    { max: 0, label: '0 mahasiswa', color: '#475569' },
    { max: 10, label: '1–10 mahasiswa', color: '#DC2626' },
    { max: 50, label: '11–50 mahasiswa', color: '#EAB308' },
    { max: 100, label: '51–100 mahasiswa', color: '#16A34A' },
    { max: null, label: '>100 mahasiswa', color: '#1D4ED8' },
];
const NO_DATA_BAND = { label: 'Belum ada data', color: '#CBD5E1' };

const INDONESIA_BOUNDS = L.latLngBounds([14.5, 94], [-12.5, 142.5]);
const CLUSTER_CHUNK_SIZE = 0.08; // degrees; buckets markers at low zoom

let map = null;
let regionLayer = null;
let clusterLayer = null;
let mode = 'marker';
let requestToken = 0;
let bands = DEFAULT_BANDS;
let lastScopeKey = null;
let lastFilterKey = null;
let lastBoundsSignature = null;
let initialBounds = null;
let programmaticMove = false;
let userInteracting = false;
let dragInProgress = false;
let pendingFit = null;
let popupMoveToken = 0;

function formatCount(value) {
    return new Intl.NumberFormat('id-ID').format(value ?? 0);
}

function scopeKey(stats) {
    return `${stats.level ?? 'provinsi'}:${stats.parent ?? 'root'}`;
}

function boundsSignature(bounds) {
    if (!bounds?.isValid()) return 'none';
    const southWest = bounds.getSouthWest();
    const northEast = bounds.getNorthEast();
    return [southWest.lat, southWest.lng, northEast.lat, northEast.lng]
        .map((value) => Number(value.toFixed(4)))
        .join(',');
}

function maxZoomFor(level) {
    return { provinsi: 7, kabupaten: 9, kecamatan: 11, desa: 13 }[level] ?? 12;
}

function setNoDataState(hasData) {
    const state = document.getElementById('student-statistics-no-data');
    if (!state) return;
    state.style.display = hasData ? 'none' : 'flex';
    state.setAttribute('aria-hidden', String(hasData));
}

function runProgrammatic(action) {
    programmaticMove = true;
    action();
    window.setTimeout(() => {
        programmaticMove = false;
    }, 1000);
}

function fitViewport(bounds, level, reason, token = requestToken) {
    if (!bounds?.isValid() || !map || token !== requestToken) return;

    const fit = () => runProgrammatic(() => {
        map.fitBounds(bounds, {
            animate: true,
            duration: 0.7,
            padding: [24, 24],
            maxZoom: maxZoomFor(level),
        });
    });

    // Initial view and drill-down are explicit user actions: they must apply.
    // Only filter-driven fits are deferred while the user is moving the map,
    // so a manual pan is never fought (requirement 8).
    const immediate = reason === 'initial' || reason === 'scope';

    if (immediate || (!dragInProgress && !userInteracting)) {
        fit();
    } else {
        pendingFit = { bounds, level, reason, token };
    }
}

function maybeFitViewport(stats, features, token) {
    if (!map || token !== requestToken) return;

    const byCode = new Map((stats.rows ?? []).map((row) => [row.code, row]));
    const active = features.filter((feature) => byCode.has(feature.properties.code));
    const bounds = L.latLngBounds([]);
    active.forEach((feature) => {
        const point = centroidOf(feature);
        if (point) bounds.extend(point);
    });

    const nextScope = scopeKey(stats);
    const nextFilter = stats.status ?? 'aktif';
    const nextSignature = boundsSignature(bounds);
    const isInitial = lastScopeKey === null;
    const scopeChanged = !isInitial && lastScopeKey !== nextScope;
    const filterChanged = !isInitial && lastFilterKey !== nextFilter;
    const boundsChanged = lastBoundsSignature !== nextSignature;

    setNoDataState(active.length > 0);

    if (!bounds.isValid()) {
        // No active data: keep the current viewport untouched (requirement 10).
        lastScopeKey = nextScope;
        lastFilterKey = nextFilter;
        lastBoundsSignature = nextSignature;
        return;
    }

    if (isInitial) {
        // Requirement 1: data-aware initial view, capped so it is neither
        // zoomed out to the whole archipelago nor pushed in too close.
        initialBounds = bounds;
        fitViewport(bounds, 'provinsi', 'initial', token);
    } else if (scopeChanged) {
        fitViewport(bounds, stats.level, 'scope', token);
    } else if (filterChanged && boundsChanged) {
        // Requirement 5: a filter change only moves the view when the
        // geographic extent of the active data actually changed.
        fitViewport(bounds, stats.level, 'filter', token);
    }

    lastScopeKey = nextScope;
    lastFilterKey = nextFilter;
    lastBoundsSignature = nextSignature;
}


/**
 * Child levels are chunked by kabupaten code: kabupaten -> province,
 * kecamatan -> kabupaten, desa -> kabupaten. Only the current chunk is
 * fetched, so the browser never loads national village data at once.
 */
function geoJsonPath(level, parent) {
    if (level === 'provinsi') return `${BASE_PATH}/provinsi.geojson`;
    if (!parent) return null;

    const slug = level === 'kabupaten' ? parent : parent.slice(0, 5);
    return `${BASE_PATH}/${level}/${slug}.geojson`;
}

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

/**
 * Marker colour for an aggregate count. `null` means SIAKAD did not report the
 * region, which is shown distinctly from a real 0 count (blank spot).
 */
function bandFor(count) {
    if (count == null) return NO_DATA_BAND;
    for (const band of bands) {
        if (band.max == null || count <= band.max) return band;
    }
    return bands[bands.length - 1];
}

function drillDown(code, name) {
    document.dispatchEvent(new CustomEvent('student-statistics-drill', { detail: { code, name } }));
}

function setLoading(isLoading) {
    const container = document.getElementById('student-statistics-map');
    const overlay = document.getElementById('student-statistics-loading');
    if (overlay) overlay.style.display = isLoading ? 'flex' : 'none';
    if (container) container.style.cursor = isLoading ? 'progress' : '';
}

function renderLegend() {
    const legend = document.getElementById('student-statistics-legend');
    if (!legend) return;

    legend.replaceChildren(
        ...[...bands, NO_DATA_BAND].map((band) => {
            const item = document.createElement('span');
            const dot = document.createElement('span');
            const label = document.createElement('span');

            item.className = 'flex items-center gap-1.5';
            dot.className = 'w-3 h-3 rounded-full border border-black/5';
            dot.style.backgroundColor = band.color;
            label.className = 'text-[11px] text-gray-500';
            label.textContent = band.label;

            item.append(dot, label);
            return item;
        }),
    );
}

/**
 * Coordinates are the administrative centroid published by the boundary data
 * source (`lat`,`lng` columns), never any student's address or location.
 */
function centroidOf(feature) {
    const { latitude, longitude } = feature.properties;
    if (Number.isFinite(latitude) && Number.isFinite(longitude)) {
        return [latitude, longitude];
    }

    // Fallback: polygon centroid, still geographic/administrative only.
    try {
        return L.geoJSON(feature).getBounds().getCenter();
    } catch {
        return null;
    }
}

function popupFor(feature, row, stats) {
    const wrapper = document.createElement('div');
    wrapper.className = 'gis-popup';

    const title = document.createElement('p');
    title.className = 'gis-popup-kicker';
    title.textContent = (stats.level ?? 'wilayah').toUpperCase();

    const name = document.createElement('h4');
    name.className = 'gis-popup-title';
    name.textContent = feature.properties.name;

    const count = document.createElement('p');
    const band = bandFor(row?.jumlah_mahasiswa ?? null);
    count.className = 'gis-popup-count';
    count.style.color = band.color === NO_DATA_BAND.color ? '#64748B' : band.color;
    count.textContent = row
        ? `${formatCount(row.jumlah_mahasiswa)} mahasiswa`
        : 'Belum ada data wilayah';

    wrapper.append(title, name, count);

    const crumbs = Array.isArray(stats.breadcrumbs) ? stats.breadcrumbs : [];
    const parents = crumbs.filter((entry) => entry && entry.code);
    for (const entry of parents) {
        const line = document.createElement('p');
        line.className = 'gis-popup-parent';
        line.textContent = `${entry.level.charAt(0).toUpperCase() + entry.level.slice(1)}: ${entry.name}`;
        wrapper.append(line);
    }

    if (stats.nextLevel) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'gis-popup-action';
        button.textContent = 'Lihat Detail';
        button.addEventListener('click', () => drillDown(feature.properties.code, feature.properties.name));
        wrapper.append(button);
    }

    const note = document.createElement('p');
    note.className = 'gis-popup-note';
    note.textContent = 'Data agregat per wilayah · tanpa data pribadi';
    wrapper.append(note);

    return wrapper;
}

function makeMarker(feature, row, stats) {
    const latlng = centroidOf(feature);
    if (!latlng) return null;

    const band = bandFor(row?.jumlah_mahasiswa ?? null);
    const marker = L.circleMarker(latlng, {
        radius: row ? Math.min(14, 6 + Math.log10(row.jumlah_mahasiswa + 1) * 4) : 5,
        color: '#FFFFFF',
        weight: 2,
        fillColor: band.color,
        fillOpacity: row ? 0.95 : 0.65,
    });

    // Popup content is captured now and opened explicitly after the flyTo
    // animation finishes; Leaflet's bindPopup would open it immediately.
    const popupContent = popupFor(feature, row, stats);
    marker.on('click', () => flyToMarker(marker, popupContent, stats));
    marker.bindTooltip(`${feature.properties.name} · ${row ? formatCount(row.jumlah_mahasiswa) + ' mahasiswa' : 'belum ada data'}`, {
        direction: 'top',
        offset: [0, -6],
    });
    return marker;
}

/**
 * Smooth flyTo to a clicked marker, then open the popup once the movement
 * settles. A token guards against a stale moveend (another click/pan) opening
 * the wrong popup. Already-visible markers open without animation.
 */
function flyToMarker(marker, content, stats) {
    if (!map) return;

    const latlng = marker.getLatLng();
    const targetZoom = Math.min(Math.max(map.getZoom() + 2, 6), maxZoomFor(stats.level), 13);
    const popup = L.popup({ closeButton: true, maxWidth: 260 })
        .setLatLng(latlng)
        .setContent(content);
    const token = ++popupMoveToken;

    const reveal = () => {
        map.off('moveend', reveal);
        if (token !== popupMoveToken) return;
        popup.openOn(map);
    };

    if (map.getBounds().contains(latlng) && map.getZoom() >= targetZoom - 0.5) {
        reveal();
        return;
    }

    map.on('moveend', reveal);
    // flyTo is a no-op when already at the target, which never fires moveend;
    // this fallback is neutralised by reveal()'s map.off().
    window.setTimeout(reveal, 1100);
    runProgrammatic(() => {
        map.flyTo(latlng, targetZoom, { animate: true, duration: 0.8 });
    });
}


/**
 * Lightweight geo-hash clustering: markers sharing a chunk bucket are grouped
 * until the map zooms in far enough for individual pins to be readable. No
 * extra dependency, no full-Indonesia marker set.
 */
function bucketKey(latlng) {
    return `${Math.floor(latlng[0] / CLUSTER_CHUNK_SIZE)}:${Math.floor(latlng[1] / CLUSTER_CHUNK_SIZE)}`;
}

function renderMarkers(features, byCode, stats) {
    const buckets = new Map();

    for (const feature of features) {
        const latlng = centroidOf(feature);
        if (!latlng) continue;

        const marker = makeMarker(feature, byCode.get(feature.properties.code), stats);
        if (!marker) continue;

        const key = bucketKey(latlng);
        if (!buckets.has(key)) buckets.set(key, { total: 0, rows: [], latlngs: [] });

        const bucket = buckets.get(key);
        bucket.rows.push(marker);
        bucket.latlngs.push(latlng);
        bucket.total += byCode.get(feature.properties.code)?.jumlah_mahasiswa ?? 0;
    }

    const group = L.layerGroup();
    const zoom = map.getZoom();

    for (const bucket of buckets.values()) {
        const single = bucket.rows.length === 1;

        if (single || zoom >= 11) {
            for (const marker of bucket.rows) group.addLayer(marker);
            continue;
        }

        const center = bucket.latlngs.reduce(
            (acc, point) => [acc[0] + point[0] / bucket.latlngs.length, acc[1] + point[1] / bucket.latlngs.length],
            [0, 0],
        );
        const cluster = L.circleMarker(center, {
            radius: Math.min(22, 10 + bucket.rows.length),
            color: '#FFFFFF',
            weight: 3,
            fillColor: bucket.total === 0 ? '#475569' : '#1B1464',
            fillOpacity: 0.9,
        });

        const label = L.divIcon({
            className: 'gis-cluster-icon',
            html: `<span>${bucket.rows.length}</span>`,
            iconSize: [40, 40],
        });
        const iconMarker = L.marker(center, { icon: label, interactive: false });
        group.addLayer(cluster);
        group.addLayer(iconMarker);

        cluster.on('click', () => {
            runProgrammatic(() => {
                map.fitBounds(L.latLngBounds(bucket.latlngs), { padding: [40, 40], maxZoom: 13 });
            });
        });
    }

    return group;
}

function initMap(container) {
    if (map) {
        if (map.getContainer() !== container) {
            map.remove();
            map = null;
            regionLayer = null;
            clusterLayer = null;
        } else {
            map.invalidateSize();
            return map;
        }
    }

    map = L.map(container, {
        scrollWheelZoom: false,
        minZoom: 4,
        maxZoom: 18,
        maxBounds: INDONESIA_BOUNDS,
        maxBoundsViscosity: 0.7,
        zoomControl: false,
        zoomSnap: 0.5,
    }).fitBounds(INDONESIA_BOUNDS, { padding: [8, 8] });

    L.control.zoom({ position: 'topright' }).addTo(map);
    L.control.scale({ imperial: false, position: 'bottomleft' }).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        minZoom: 4,
        filter: 'saturate(0.55) brightness(1.04)',
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    // Defer a queued fit while the user is dragging or animating manually;
    // apply it when they let go (still current via the request token).
    // Programmatic moves are flagged so our own animations are never
    // mistaken for user gestures (requirement 8: don't fight manual pan/zoom).
    map.on('dragstart', () => {
        dragInProgress = true;
        userInteracting = true;
    });
    map.on('dragend', () => {
        dragInProgress = false;
        window.setTimeout(() => {
            if (!dragInProgress) {
                userInteracting = false;
                flushPendingFit();
            }
        }, 250);
    });
    map.on('movestart zoomstart', () => {
        if (!programmaticMove) userInteracting = true;
    });
    map.on('moveend zoomend', () => {
        if (!programmaticMove && !dragInProgress) {
            window.setTimeout(() => {
                if (!dragInProgress && !programmaticMove) {
                    userInteracting = false;
                    flushPendingFit();
                }
            }, 250);
        }
        applyMode();
    });
    return map;
}

function flushPendingFit() {
    const queued = pendingFit;
    pendingFit = null;
    if (queued && queued.token === requestToken) {
        fitViewport(queued.bounds, queued.level, queued.reason, queued.token);
    }
}

function applyMode() {
    if (!map) return;

    if (regionLayer && map.hasLayer(regionLayer)) map.removeLayer(regionLayer);
    if (clusterLayer && map.hasLayer(clusterLayer)) map.removeLayer(clusterLayer);

    if (mode === 'region' && regionLayer) {
        regionLayer.addTo(map);
    } else if (mode === 'marker' && clusterLayer) {
        clusterLayer.addTo(map);
    }
}

function setActiveModeButtons() {
    for (const button of document.querySelectorAll('[data-gis-mode]')) {
        const active = button.dataset.gisMode === mode;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', String(active));
    }
}

function render(stats) {
    const container = document.getElementById('student-statistics-map');
    if (!container) return;

    const path = geoJsonPath(stats.level, stats.parent);
    if (!path) return;

    const activeMap = initMap(container);
    const token = ++requestToken;
    const nextScopeKey = scopeKey(stats);
    if (lastScopeKey !== null && lastScopeKey !== nextScopeKey) {
        // A relevant geography transition supersedes any user's previous view.
        popupMoveToken += 1;
        activeMap.closePopup();
    }

    if (Array.isArray(stats.bands) && stats.bands.length > 0) bands = stats.bands;
    if (stats.mode === 'region' || stats.mode === 'marker') mode = stats.mode;
    setActiveModeButtons();
    renderLegend();

    if (regionLayer) activeMap.removeLayer(regionLayer);
    if (clusterLayer) activeMap.removeLayer(clusterLayer);
    regionLayer = null;
    clusterLayer = null;

    const counts = (stats.rows ?? []).map((row) => row.jumlah_mahasiswa);
    const byCode = new Map((stats.rows ?? []).map((row) => [row.code, row]));
    const scale = buildScale(counts);

    setLoading(true);

    fetch(path)
        .then((response) => {
            if (!response.ok) throw new Error(`geojson ${response.status}`);
            return response.json();
        })
        .then((geojson) => {
            if (token !== requestToken) return;

            regionLayer = L.geoJSON(geojson, {
                style(feature) {
                    const row = byCode.get(feature.properties.code);
                    const fill = row ? (scale(row.jumlah_mahasiswa) ?? RAMP[0]) : NO_DATA;
                    return {
                        fillColor: fill,
                        weight: 1,
                        color: '#FFFFFF',
                        opacity: 1,
                        fillOpacity: row ? 0.88 : 0.45,
                    };
                },
                onEachFeature(feature, featureLayer) {
                    const row = byCode.get(feature.properties.code);

                    if (stats.nextLevel) {
                        // Navigable region: click drills down. Binding a popup
                        // here would open it only to be replaced immediately.
                        featureLayer.on('click', () => drillDown(feature.properties.code, feature.properties.name));
                    } else {
                        // Terminal level (desa): the region itself carries detail.
                        featureLayer.bindPopup(popupFor(feature, row, stats));
                    }

                    featureLayer.bindTooltip(
                        () => {
                            const wrapper = document.createElement('div');
                            const title = document.createElement('strong');
                            const value = document.createElement('div');

                            wrapper.className = 'gis-tooltip';
                            title.className = 'gis-tooltip-title';
                            value.className = row ? 'gis-tooltip-value' : 'gis-tooltip-value is-empty';

                            title.textContent = feature.properties.name;
                            value.textContent = row
                                ? `${formatCount(row.jumlah_mahasiswa)} mahasiswa`
                                : 'Belum ada data wilayah';

                            wrapper.append(title, value);
                            return wrapper;
                        },
                        { sticky: true, direction: 'top', opacity: 1 },
                    );

                    featureLayer.on('mouseover', () => {
                        featureLayer.setStyle({ weight: 2, color: '#FDE01A', fillOpacity: 1 });
                        featureLayer.bringToFront();
                    });
                    featureLayer.on('mouseout', () => regionLayer?.resetStyle(featureLayer));
                },
            });

            clusterLayer = renderMarkers(geojson.features, byCode, stats);

            // Smart auto-zoom: replaces the old unconditional fitBounds.
            maybeFitViewport(stats, geojson.features, token);

            applyMode();
            setLoading(false);
        })
        .catch(() => {
            if (token === requestToken) setLoading(false);
            // Boundaries are optional: the accessible list keeps working.
        });
}

function readStats(element) {
    if (element?.dataset.stats) return JSON.parse(element.dataset.stats);
    return window.studentStatisticsInitial ?? {};
}

function resetViewport() {
    if (!map) return;

    pendingFit = null;
    const target = initialBounds?.isValid() ? initialBounds : INDONESIA_BOUNDS;
    userInteracting = false;
    runProgrammatic(() => {
        map.fitBounds(target, { animate: true, duration: 0.7, padding: [8, 8], maxZoom: 7 });
    });
}

function statsFromEvent(event) {
    const detail = event.detail ?? {};
    return {
        rows: detail.rows ?? [],
        level: detail.level ?? 'provinsi',
        parent: detail.parent ?? null,
        parentName: detail.parentName ?? null,
        breadcrumbs: detail.breadcrumbs ?? [],
        nextLevel: detail.nextLevel ?? null,
        status: detail.status ?? 'aktif',
        bands: detail.bands ?? bands,
        mode,
    };
}

document.addEventListener('student-statistics-updated', (event) => render(statsFromEvent(event)));

document.addEventListener('livewire:navigated', () => render(readStats(document.getElementById('student-statistics-map'))));

document.addEventListener('click', (event) => {
    if (event.target.closest?.('[data-gis-reset]')) {
        // Viewport only: hierarchy and filter are intentionally preserved.
        resetViewport();
        return;
    }

    const button = event.target.closest?.('[data-gis-mode]');
    if (!button || button.disabled) return;

    // Presentation only — switching mode never moves the viewport.
    mode = button.dataset.gisMode;
    setActiveModeButtons();
    applyMode();
});

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => render(readStats(document.getElementById('student-statistics-map'))));
} else {
    render(readStats(document.getElementById('student-statistics-map')));
}
