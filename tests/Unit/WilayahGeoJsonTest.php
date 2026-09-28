<?php

namespace Tests\Unit;

use Tests\TestCase;

class WilayahGeoJsonTest extends TestCase
{
    private string $root;

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = public_path('data/wilayah');
    }

    public function test_representative_api_codes_have_finite_administrative_centroids(): void
    {
        $examples = [
            ['53', 'provinsi.geojson'],
            ['53.18', 'kabupaten/53.geojson'],
            ['53.18.04', 'kecamatan/53.18.geojson'],
            ['53.18.04.2022', 'desa/53.18.geojson'],
        ];

        foreach ($examples as [$code, $file]) {
            $collection = json_decode(file_get_contents("{$this->root}/{$file}"), true, flags: JSON_THROW_ON_ERROR);
            $feature = collect($collection['features'])->firstWhere('properties.code', $code);

            $this->assertNotNull($feature, "Missing geometry for {$code}");
            $this->assertArrayHasKey('latitude', $feature['properties']);
            $this->assertArrayHasKey('longitude', $feature['properties']);
            $this->assertGreaterThanOrEqual(-11.5, $feature['properties']['latitude']);
            $this->assertLessThanOrEqual(6.5, $feature['properties']['latitude']);
            $this->assertGreaterThanOrEqual(94, $feature['properties']['longitude']);
            $this->assertLessThanOrEqual(143, $feature['properties']['longitude']);
        }
    }

    public function test_absent_siadak_row_is_not_a_confirmed_zero(): void
    {
        $collection = json_decode(file_get_contents("{$this->root}/desa/53.18.geojson"), true, flags: JSON_THROW_ON_ERROR);
        $feature = collect($collection['features'])->firstWhere('properties.code', '53.18.04.2022');
        $reportedRows = [];

        $this->assertNotNull($feature);
        $this->assertArrayNotHasKey($feature['properties']['code'], $reportedRows);
        $this->assertNull($reportedRows[$feature['properties']['code']] ?? null);
    }
}
