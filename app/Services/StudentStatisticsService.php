<?php

namespace App\Services;

use App\Exceptions\StatisticsUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class StudentStatisticsService
{
    private const MAX_ROWS = 100_000;

    public function forLevel(string $level, ?string $parent = null, string $status = 'aktif'): array
    {
        $this->validateLevel($level);
        $this->validateStatus($status);
        $this->validateParent($parent);

        $cacheKey = implode(':', [
            config('siakad.cache_namespace'),
            $level,
            $parent ?? 'root',
            $status,
        ]);

        return Cache::remember($cacheKey, config('siakad.cache_ttl', 600), function () use ($level, $parent, $status) {
            return $this->fetch($level, $parent, $status);
        });
    }

    private function fetch(string $level, ?string $parent, string $status): array
    {
        $parameters = ['level' => $level, 'status' => $status];
        if ($parent !== null) {
            $parameters['parent'] = $parent;
        }

        try {
            $response = $this->client()->get('/wilayah/statistik', $parameters);
        } catch (ConnectionException $exception) {
            Log::warning('SIAKAD statistik connection failed', [
                'level' => $level,
                'has_parent' => $parent !== null,
                'status' => $status,
            ]);
            throw new StatisticsUnavailableException(reason: 'connection', previous: $exception);
        }

        if ($response->failed()) {
            Log::warning('SIAKAD statistik returned an error', [
                'level' => $level,
                'has_parent' => $parent !== null,
                'status' => $status,
                'http_status' => $response->status(),
            ]);
            throw new StatisticsUnavailableException(reason: 'upstream');
        }

        $payload = $response->json();
        if (! is_array($payload) || ! is_array($payload['data'] ?? null)) {
            Log::error('SIAKAD statistik returned an invalid payload', [
                'level' => $level,
                'status' => $status,
            ]);
            throw new StatisticsUnavailableException(reason: 'payload');
        }

        if (count($payload['data']) > self::MAX_ROWS) {
            Log::error('SIAKAD statistik returned too many rows', ['level' => $level]);
            throw new StatisticsUnavailableException(reason: 'payload');
        }

        $rows = [];
        foreach ($payload['data'] as $row) {
            if (! is_array($row) || ! $this->validCode($row['code'] ?? null) || ! is_string($row['name'] ?? null)) {
                continue;
            }

            $count = filter_var($row['jumlah_mahasiswa'] ?? null, FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 0],
            ]);
            if ($count === false) {
                continue;
            }

            $rows[] = [
                'code' => $row['code'],
                'name' => trim($row['name']),
                'jumlah_mahasiswa' => $count,
            ];
        }

        $meta = is_array($payload['meta'] ?? null) ? $payload['meta'] : [];

        return [
            'rows' => $rows,
            'meta' => [
                'level' => $level,
                'status' => $status,
                'generated_at' => is_string($meta['generated_at'] ?? null) ? $meta['generated_at'] : null,
                'total' => count($rows),
            ],
        ];
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl(rtrim(config('siakad.base_url'), '/'))
            ->acceptJson()
            ->connectTimeout(config('siakad.connect_timeout', 2))
            ->timeout(config('siakad.timeout', 5));
    }

    private function validateLevel(string $level): void
    {
        if (! in_array($level, config('siakad.levels', []), true)) {
            throw new InvalidArgumentException('Level statistik tidak valid.');
        }
    }

    private function validateStatus(string $status): void
    {
        if (! in_array($status, config('siakad.statuses', []), true)) {
            throw new InvalidArgumentException('Status statistik tidak valid.');
        }
    }

    private function validateParent(?string $parent): void
    {
        if ($parent !== null && ! $this->validCode($parent)) {
            throw new InvalidArgumentException('Kode wilayah induk tidak valid.');
        }
    }

    private function validCode(mixed $code): bool
    {
        if (! is_string($code)) {
            return false;
        }

        $segments = explode('.', $code);
        $expectedLengths = match (count($segments)) {
            1 => [2],
            2 => [2, 2],
            3 => [2, 2, 2],
            4 => [2, 2, 2, 4],
            default => [],
        };

        if ($expectedLengths === [] || count($segments) !== count($expectedLengths)) {
            return false;
        }

        foreach ($segments as $index => $segment) {
            if (strlen($segment) !== $expectedLengths[$index] || ! ctype_digit($segment)) {
                return false;
            }
        }

        return true;
    }
}
