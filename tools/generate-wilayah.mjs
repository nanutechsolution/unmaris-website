import { createReadStream, mkdirSync, writeFileSync, rmSync } from 'node:fs';
import { createGunzip } from 'node:zlib';
import { createInterface } from 'node:readline';
import { join } from 'node:path';

const sourceDir = process.argv[2] ?? 'storage/app/wilayah-build';
const outputDir = process.argv[3] ?? 'storage/app/wilayah-build/geojson';
const files = ['b1.sql.gz', 'b2.sql.gz', 'b3.sql.gz', 'b4.sql.gz'];
const levels = { 1: 'provinsi', 2: 'kabupaten', 3: 'kecamatan', 4: 'desa' };
const CODE_WIDTHS = [2, 2, 2, 4];
const features = Object.fromEntries(Object.values(levels).map((level) => [level, []]));

rmSync(outputDir, { recursive: true, force: true });
mkdirSync(outputDir, { recursive: true });

/**
 * Source rows look like:
 *   \t('53.18','Kabupaten Sumba Barat Daya',-9.53,119.17,'[[[[lat,lng],...]]]'),\n
 * Names may contain a doubled quote (``''``), so a single regex is not enough.
 */
function isValidCode(code) {
    const segments = code.split('.');
    if (segments.length > CODE_WIDTHS.length) return false;
    return segments.every((segment, index) => segment.length === CODE_WIDTHS[index] && /^\d+$/.test(segment));
}

function parseTuple(line) {
    const source = line.trimStart();
    if (source[0] !== '(') return null;

    const fields = [];
    let index = 1;

    while (index < source.length) {
        const character = source[index];

        if (character === "'") {
            let value = '';
            index += 1;

            while (index < source.length) {
                if (source[index] !== "'") {
                    value += source[index];
                    index += 1;
                    continue;
                }

                if (source[index + 1] === "'") {
                    value += "'";
                    index += 2;
                    continue;
                }

                index += 1;
                break;
            }

            fields.push(value);
        } else if (character === ')') {
            break;
        } else if (character === ',') {
            index += 1;
        } else {
            const start = index;
            while (index < source.length && source[index] !== ',' && source[index] !== ')') index += 1;
            fields.push(source.slice(start, index).trim());
        }

        while (index < source.length && (source[index] === ' ' || source[index] === '\t')) index += 1;
    }

    if (fields.length !== 5) return null;

    const [code, name, , , rawPath] = fields;
    if (!isValidCode(code) || !name) return null;

    try {
        return { code, name, path: swapLatLng(JSON.parse(rawPath)) };
    } catch {
        return null;
    }
}

/** Source stores [lat, lng]; GeoJSON/Leaflet require [lng, lat]. */
function swapLatLng(value) {
    if (!Array.isArray(value)) return value;
    if (value.length === 2 && typeof value[0] === 'number' && typeof value[1] === 'number') {
        return [value[1], value[0]];
    }
    return value.map(swapLatLng);
}

function detectGeometry(path) {
    return {
        type: Array.isArray(path[0]?.[0]?.[0]) ? 'MultiPolygon' : 'Polygon',
        coordinates: path,
    };
}

const skipped = { badLine: 0, badCode: 0, badPath: 0 };

for (const file of files) {
    const input = createReadStream(join(sourceDir, file)).pipe(createGunzip());
    const lines = createInterface({ input, crlfDelay: Infinity });

    for await (const line of lines) {
        if (line[0] !== '\t') continue;

        const tuple = parseTuple(line);
        if (!tuple) { skipped.badLine += 1; continue; }

        const level = tuple.code.split('.').length;
        if (!levels[level]) { skipped.badCode += 1; continue; }

        features[levels[level]].push({
            type: 'Feature',
            properties: { code: tuple.code, name: tuple.name },
            geometry: detectGeometry(tuple.path),
        });
    }
}

for (const [level, rows] of Object.entries(features)) {
    rows.sort((a, b) => a.properties.code.localeCompare(b.properties.code));
    const payload = JSON.stringify({ type: 'FeatureCollection', features: rows });
    writeFileSync(join(outputDir, `${level}.geojson`), payload);
    console.log(`${level}: ${rows.length} features, ${Math.round(Buffer.byteLength(payload) / 1024 / 1024)} MB`);
}

console.log(`skipped rows: ${JSON.stringify(skipped)}`);
