# Wilayah GeoJSON assets

These files are generated from the MIT-licensed `cahyadsn/wilayah` boundary data, sourced via the `edopandoyo/wilayah-indonesia-api` boundary SQL release. The source contains coded administrative boundaries for provinces, kabupaten/kota, kecamatan, and desa/kelurahan.

## Generated layout

- `provinsi.geojson` contains all province features.
- `kabupaten/{province-code}.geojson` contains kabupaten/kota for one province.
- `kecamatan/{kabupaten-code}.geojson` contains kecamatan for one kabupaten/kota.
- `desa/{kabupaten-code}.geojson` contains desa/kelurahan for one kabupaten/kota. The page lazy-loads this chunk only at the desa level.

The checked-in assets are simplified for browser use. They retain exact `properties.code` and `properties.name` values, and the source latitude/longitude order has been converted to GeoJSON longitude/latitude order. The browser joins features to SIAKAD rows by exact code; it never matches by name.

## Rebuild

Keep compressed source files outside git in `storage/app/wilayah-build/`, then run:

```sh
node tools/generate-wilayah.mjs storage/app/wilayah-build storage/app/wilayah-build/geojson
```

Apply the reviewed mapshaper simplification to each generated level, split the child levels using the same code prefixes, and validate representative exact joins for `53`, `53.18`, `53.18.04`, and `53.18.04.2022`. Serve the files with HTTP compression.

Source: https://github.com/cahyadsn/wilayah
License: MIT
