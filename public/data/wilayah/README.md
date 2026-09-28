# Wilayah GeoJSON assets

Generated from the MIT-licensed `cahyadsn/wilayah` boundary data (provided as
boundary SQL by `edopandoyo/wilayah-indonesia-api`). Each feature preserves:
`code`, `name`, `latitude`, and `longitude`. The latter two are administrative
centroids from source `lat`/`lng` columns, never student coordinates.

## Chunk layout

- `provinsi.geojson`: all 37 province features.
- `kabupaten/{province-code}.geojson`: kabupaten/kota within one province.
- `kecamatan/{kabupaten-code}.geojson`: kecamatan within one kabupaten/kota.
- `desa/{kabupaten-code}.geojson`: villages within one kabupaten/kota.

The map lazy-loads only the active level/chunk and joins counts by exact API
code. A geometry with no SIAKAD row is shown as “Belum ada data”, not as a
confirmed zero. No personal student data is stored or sent to the browser.

The source has no desa-level geometry rows for kabupaten `12.01`; that chunk is
intentionally absent. The UI does not invent geometry for it.

## Rebuild

Keep the compressed source SQL outside git in `storage/app/wilayah-build/`.
Run the generator, simplify each level using the reviewed mapshaper parameters
(province/kabupaten/kecamatan: 8%; desa: 3%), and split the child level files
by the parent-code layout above. Confirm these exact joins and centroid ranges
after each rebuild: `53`, `53.18`, `53.18.04`, `53.18.04.2022`.

Source: https://github.com/cahyadsn/wilayah (MIT)
