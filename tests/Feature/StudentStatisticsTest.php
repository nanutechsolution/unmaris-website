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
}
