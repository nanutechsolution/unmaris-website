<?php

namespace Tests\Unit;

use App\Exceptions\StatisticsUnavailableException;
use App\Services\StudentStatisticsService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Tests\TestCase;

class StudentStatisticsServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    private function service(): StudentStatisticsService
    {
        return new StudentStatisticsService;
    }

    private function payload(array $rows, array $meta = []): array
    {
        return [
            'data' => $rows,
            'meta' => $meta + ['level' => 'provinsi', 'status' => 'aktif', 'generated_at' => '2026-09-27T00:00:00+08:00'],
        ];
    }

    public function test_it_fetches_the_expected_aggregate_endpoint(): void
    {
        Http::fake(['*' => Http::response($this->payload([
            ['code' => '53', 'name' => 'Nusa Tenggara Timur', 'jumlah_mahasiswa' => 1204],
        ]))]);

        $result = $this->service()->forLevel('provinsi', null, 'aktif');

        Http::assertSent(function (Request $request) {
            return str_starts_with($request->url(), 'https://siakad.unmarissumba.ac.id/api/v1/wilayah/statistik')
                && $request['level'] === 'provinsi'
                && $request['status'] === 'aktif'
                && ! array_key_exists('parent', $request->data());
        });

        $this->assertSame('53', $result['rows'][0]['code']);
        $this->assertSame(1204, $result['rows'][0]['jumlah_mahasiswa']);
        $this->assertSame(1, $result['meta']['total']);
    }

    public function test_it_passes_the_parent_code_and_status_filter(): void
    {
        Http::fake(['*' => Http::response($this->payload([]))]);

        $this->service()->forLevel('kabupaten', '53.18', 'semua');

        Http::assertSent(fn (Request $request) => $request['parent'] === '53.18' && $request['status'] === 'semua');
    }

    public function test_it_rejects_invalid_input_without_calling_the_api(): void
    {
        Http::fake();

        $invalid = [
            ['provinsi', 'tidak-ada', 'aktif'],
            ['bogus', null, 'aktif'],
            ['provinsi', null, 'bogus'],
            ['provinsi', '53.', 'aktif'],
        ];

        foreach ($invalid as [$level, $parent, $status]) {
            try {
                $this->service()->forLevel($level, $parent, $status);
                $this->fail('Expected InvalidArgumentException');
            } catch (InvalidArgumentException) {
                $this->addToAssertionCount(1);
            }
        }

        Http::assertNothingSent();
    }

    public function test_it_caches_successful_responses_for_the_configured_ttl(): void
    {
        Http::fake(['*' => Http::response($this->payload([
            ['code' => '53', 'name' => 'Nusa Tenggara Timur', 'jumlah_mahasiswa' => 1],
        ]))]);

        $this->service()->forLevel('provinsi');
        $this->service()->forLevel('provinsi');

        Http::assertSentCount(1);
    }

    public function test_cache_keys_are_isolated_by_level_parent_and_status(): void
    {
        Http::fake(['*' => Http::response($this->payload([]))]);

        $this->service()->forLevel('provinsi');
        $this->service()->forLevel('provinsi', null, 'semua');
        $this->service()->forLevel('kabupaten', '53');

        Http::assertSentCount(3);
    }

    public function test_it_only_exposes_code_name_and_count_fields(): void
    {
        Http::fake(['*' => Http::response($this->payload([
            [
                'code' => '53',
                'name' => 'Nusa Tenggara Timur',
                'jumlah_mahasiswa' => 1204,
                'nim' => '1234567890',
                'nik' => '3501234567890001',
                'mahasiswa' => [['nama' => 'Seseorang', 'nim' => '2020001']],
            ],
        ]))]);

        $row = $this->service()->forLevel('provinsi')['rows'][0];

        $this->assertSame(['code', 'name', 'jumlah_mahasiswa'], array_keys($row));
    }

    public function test_it_drops_malformed_rows_and_counts(): void
    {
        Http::fake(['*' => Http::response($this->payload([
            ['code' => '53', 'name' => 'Nusa Tenggara Timur', 'jumlah_mahasiswa' => 5],
            ['code' => '53.18', 'name' => 'Kabupaten Sumba Barat Daya', 'jumlah_mahasiswa' => -1],
            ['code' => 'not-a-code', 'name' => 'Tidak Valid', 'jumlah_mahasiswa' => 5],
            ['code' => '53.18', 'name' => 'Tanpa Jumlah'],
            ['code' => '53.19', 'name' => 'Kabupaten Manggarai Timur', 'jumlah_mahasiswa' => '12'],
        ]))]);

        $rows = $this->service()->forLevel('provinsi')['rows'];

        $this->assertCount(2, $rows);
        $this->assertSame(['53', '53.19'], array_column($rows, 'code'));
        $this->assertSame([5, 12], array_column($rows, 'jumlah_mahasiswa'));
    }

    public function test_it_fails_safely_on_a_timeout(): void
    {
        Http::fake(fn () => throw new ConnectionException('cURL error 28: timeout'));

        try {
            $this->service()->forLevel('provinsi');
            $this->fail('Expected StatisticsUnavailableException');
        } catch (StatisticsUnavailableException $exception) {
            $this->assertSame('connection', $exception->reason());
        }
    }

    public function test_it_fails_safely_on_an_upstream_error(): void
    {
        Http::fake(['*' => Http::response(['message' => 'Server error'], 500)]);

        $this->expectException(StatisticsUnavailableException::class);
        $this->service()->forLevel('provinsi');
    }

    public function test_it_fails_safely_on_a_malformed_payload(): void
    {
        Http::fake(['*' => Http::response('<html>oops</html>', 200, ['Content-Type' => 'text/html'])]);

        $this->expectException(StatisticsUnavailableException::class);
        $this->service()->forLevel('provinsi');
    }

    public function test_it_does_not_cache_failures(): void
    {
        Http::fake([
            'https://siakad.unmarissumba.ac.id/api/v1/wilayah/statistik*' => Http::response([], 500),
        ]);

        try {
            $this->service()->forLevel('provinsi');
        } catch (StatisticsUnavailableException) {
            $this->addToAssertionCount(1);
        }

        Http::assertSentCount(1);
        $this->assertNull(Cache::get('siakad.statistik.v1:provinsi:root:aktif'));
    }
}
