<?php

namespace App\Livewire;

use App\Exceptions\StatisticsUnavailableException;
use App\Services\StudentStatisticsService;
use InvalidArgumentException;
use Livewire\Component;

class StudentStatistics extends Component
{
    public string $status = 'semua';

    /**
     * Hirarki yang sedang ditampilkan. Setiap entri adalah wilayah yang pernah
     * dilihat: {level, code, name}. Entri pertama selalu tingkat provinsi.
     */
    public array $stack = [];

    public array $rows = [];

    public array $meta = [];

    public ?string $error = null;

    public bool $loading = false;

    protected $queryString = [
        'status' => ['except' => 'aktif'],
    ];

    public function mount(StudentStatisticsService $service): void
    {
        $this->stack = [['level' => 'provinsi', 'code' => null, 'name' => 'Indonesia']];
        $this->load($service);
    }

    public function setStatus(string $status): void
    {
        if (! in_array($status, ['aktif', 'semua'], true)) {
            return;
        }

        $this->status = $status;
        $this->stack = [['level' => 'provinsi', 'code' => null, 'name' => 'Indonesia']];
        $this->load(app(StudentStatisticsService::class));
    }

    public function drillDown(string $code, ?string $name = null): void
    {
        $current = $this->current();
        $nextLevel = $this->childLevel($current['level']);

        // The clicked code belongs to the level currently on screen; the child
        // level is implied by it, so validate against $current.
        if ($nextLevel === null || ! $this->codeMatchesLevel($code, $current['level'])) {
            return;
        }

        // Prefer the name carried by the statistics row, then the one supplied
        // by the GeoJSON feature, then a neutral label.
        $rowName = collect($this->rows)->firstWhere('code', $code)['name'] ?? null;
        $name = $rowName ?? (is_string($name) && trim($name) !== '' ? trim($name) : 'Wilayah');

        $this->stack[] = ['level' => $nextLevel, 'code' => $code, 'name' => $name];
        $this->load(app(StudentStatisticsService::class));
    }

    public function back(): void
    {
        if (count($this->stack) <= 1) {
            return;
        }

        array_pop($this->stack);
        $this->load(app(StudentStatisticsService::class));
    }

    public function resetToRoot(): void
    {
        $this->stack = [['level' => 'provinsi', 'code' => null, 'name' => 'Indonesia']];
        $this->load(app(StudentStatisticsService::class));
    }

    public function retry(): void
    {
        $this->load(app(StudentStatisticsService::class));
    }

    public function render()
    {
        $topRows = collect($this->rows)
            ->sortBy(fn (array $row) => [$row['jumlah_mahasiswa'], $row['name']], SORT_DESC)
            ->take(10)
            ->values()
            ->all();

        return view('livewire.student-statistics', [
            'current' => $this->current(),
            'crumbs' => array_values(array_filter($this->stack, fn (array $entry) => $entry['code'] !== null)),
            'topRows' => $topRows,
            'nextLevel' => $this->childLevel($this->current()['level']),
            'canGoBack' => count($this->stack) > 1,
            'markerBands' => config('siakad.marker_bands', []),
        ])->layout('components.layouts.app', [
            'title' => 'GIS Statistik Mahasiswa - UNMARIS',
            'description' => 'Peta persebaran mahasiswa UNMARIS per wilayah, disajikan secara agregat.',
        ]);
    }

    private function load(StudentStatisticsService $service): void
    {
        $current = $this->current();

        $this->loading = true;
        $this->error = null;

        try {
            $result = $service->forLevel($current['level'], $current['code'], $this->status);
            $this->rows = $result['rows'];
            $this->meta = $result['meta'];
            $this->error = null;
        } catch (InvalidArgumentException) {
            $this->rows = [];
            $this->meta = [];
            $this->error = 'Pilihan wilayah atau status tidak valid.';
        } catch (StatisticsUnavailableException) {
            $this->rows = [];
            $this->meta = [];
            $this->error = 'Data statistik sedang tidak tersedia. Silakan coba lagi.';
        } finally {
            $this->loading = false;
        }

        $this->dispatch(
            'student-statistics-updated',
            rows: $this->rows,
            level: $current['level'],
            parent: $current['code'],
            parentName: $current['name'],
            breadcrumbs: $this->stack,
            bands: config('siakad.marker_bands', []),
            nextLevel: $this->childLevel($current['level']),
            status: $this->status,
        );
    }

    private function current(): array
    {
        return end($this->stack) ?: ['level' => 'provinsi', 'code' => null, 'name' => 'Indonesia'];
    }

    private function childLevel(string $level): ?string
    {
        return match ($level) {
            'provinsi' => 'kabupaten',
            'kabupaten' => 'kecamatan',
            'kecamatan' => 'desa',
            default => null,
        };
    }

    private function codeMatchesLevel(string $code, string $level): bool
    {
        $segments = explode('.', $code);
        $expected = match ($level) {
            'provinsi' => 1,
            'kabupaten' => 2,
            'kecamatan' => 3,
            'desa' => 4,
            default => 0,
        };

        if (count($segments) !== $expected) {
            return false;
        }

        // Segment widths are 2/2/2/4, matching the SIAKAD code format.
        $widths = array_slice([2, 2, 2, 4], 0, $expected);
        foreach ($segments as $index => $segment) {
            if (strlen($segment) !== $widths[$index] || ! ctype_digit($segment)) {
                return false;
            }
        }

        return true;
    }
}
