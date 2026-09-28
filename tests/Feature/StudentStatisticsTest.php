<?php

namespace Tests\Feature;

use App\Livewire\StudentStatistics;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class StudentStatisticsTest extends TestCase
{
    private function fakeStatistics(): void
    {
        Http::fake([
            'https://siakad.unmarissumba.ac.id/api/v1/wilayah/statistik*' => function ($request) {
                return Http::response([
                    'data' => match ($request['level']) {
                        'provinsi' => [[
                            'code' => '53',
                            'name' => 'Nusa Tenggara Timur',
                            'jumlah_mahasiswa' => 4,
                            // Upstream must never leak these to visitors.
                            'nim' => '2020123456',
                            'nik' => '5301012345678901',
                            'mahasiswa' => [['nama' => 'Contoh Mahasiswa', 'nim' => '2020123456']],
                        ]],
                        'kabupaten' => [['code' => '53.18', 'name' => 'Kabupaten Sumba Barat Daya', 'jumlah_mahasiswa' => 4]],
                        'kecamatan' => [['code' => '53.18.04', 'name' => 'Wewewa Barat', 'jumlah_mahasiswa' => 4]],
                        default => [['code' => '53.18.04.2022', 'name' => 'Lolo Ole', 'jumlah_mahasiswa' => 4]],
                    },
                    'meta' => ['level' => $request['level'], 'status' => $request['status'], 'total' => 1],
                ]);
            },
        ]);
    }

    public function test_the_public_route_renders_the_statistics_page(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));

        $response->assertOk()
            ->assertSee('GIS')
            ->assertSee('Statistik Mahasiswa')
            ->assertSee('Nusa Tenggara Timur')
            ->assertDontSee('2020123456')
            ->assertDontSee('5301012345678901')
            ->assertDontSee('Contoh Mahasiswa');
    }

    public function test_marker_is_the_default_map_mode_with_wilayah_fallback(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));

        $response->assertOk()
            ->assertSee('data-gis-mode="marker"', false)
            ->assertSee('gis-mode-button is-active', false)
            ->assertSee('data-gis-mode="region"', false)
            // Heatmap is staged but not shipped with unverified performance.
            ->assertSee('disabled title="Segera hadir"', false);
    }

    public function test_marker_thresholds_come_from_configuration_not_hardcoded_ui(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));
        $this->assertNotEmpty(config('siakad.marker_bands'));

        $response->assertOk();

        // Thresholds must be present in the payload the renderer consumes.
        // The data-* attribute is HTML-escaped, so look for the encoded form.
        foreach ([0, 10, 50, 100] as $max) {
            $this->assertStringContainsString(sprintf('&quot;max&quot;:%d,', $max), $response->getContent());
        }
    }

    public function test_unsupported_year_program_campus_filters_are_not_advertised(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));

        // SIAKAD ignores these parameters; the UI must not imply otherwise.
        $response->assertOk()
            ->assertDontSee('name="tahun"')
            ->assertDontSee('name="prodi"')
            ->assertDontSee('name="kampus"')
            ->assertDontSee('Prodi terbanyak');
    }

    public function test_livewire_can_drill_down_and_return(): void
    {
        $this->fakeStatistics();

        Livewire::test(StudentStatistics::class)
            ->assertSet('status', 'aktif')
            ->call('drillDown', '53')
            ->assertSet('stack.1.level', 'kabupaten')
            ->assertSet('stack.1.code', '53')
            ->call('drillDown', '53.18')
            ->assertSet('stack.2.level', 'kecamatan')
            ->call('back')
            ->assertSet('stack.1.level', 'kabupaten')
            ->call('resetToRoot')
            ->assertSet('stack.0.level', 'provinsi');
    }

    public function test_livewire_status_filter_returns_to_the_root(): void
    {
        $this->fakeStatistics();

        Livewire::test(StudentStatistics::class)
            ->call('drillDown', '53')
            ->call('setStatus', 'semua')
            ->assertSet('status', 'semua')
            ->assertCount('stack', 1);
    }

    public function test_invalid_drill_down_code_does_not_change_state(): void
    {
        $this->fakeStatistics();

        Livewire::test(StudentStatistics::class)
            ->call('drillDown', 'not-a-code')
            ->assertCount('stack', 1);
    }

    public function test_map_renders_reset_control_and_no_data_state(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));

        $response->assertOk()
            ->assertSee('data-gis-reset', false)
            ->assertSee('Reset Tampilan')
            ->assertSee('Tidak ada data pada filter ini');
    }

    public function test_initial_map_payload_carries_the_active_filter(): void
    {
        $this->fakeStatistics();
        $this->withoutVite();

        $response = $this->get(route('kemahasiswaan.statistik'));

        // The viewport state machine needs the same filter key on first render
        // as it receives on every later Livewire dispatch.
        $response->assertOk()->assertSee('&quot;status&quot;:&quot;aktif&quot;', false);
    }

    public function test_dispatch_carries_status_and_scope_for_the_viewport_state_machine(): void
    {
        $this->fakeStatistics();

        Livewire::test(StudentStatistics::class)
            ->assertDispatched('student-statistics-updated', function (string $event, array $params) {
                return $params['status'] === 'aktif'
                    && $params['level'] === 'provinsi'
                    && $params['parent'] === null;
            })
            ->call('drillDown', '53')
            ->assertDispatched('student-statistics-updated', function (string $event, array $params) {
                return $params['status'] === 'aktif'
                    && $params['level'] === 'kabupaten'
                    && $params['parent'] === '53';
            })
            ->call('setStatus', 'semua')
            ->assertDispatched('student-statistics-updated', function (string $event, array $params) {
                return $params['status'] === 'semua'
                    && $params['level'] === 'provinsi'
                    && $params['parent'] === null;
            });
    }
}
