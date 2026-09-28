<?php

return [
    'base_url' => env('SIAKAD_API_BASE_URL', 'https://siakad.unmarissumba.ac.id/api/v1'),
    'connect_timeout' => (int) env('SIAKAD_CONNECT_TIMEOUT', 2),
    'timeout' => (int) env('SIAKAD_TIMEOUT', 5),
    'cache_ttl' => (int) env('SIAKAD_CACHE_TTL', 600),
    'cache_namespace' => 'siakad.statistik.v1',
    'levels' => ['provinsi', 'kabupaten', 'kecamatan', 'desa'],
    'statuses' => ['aktif', 'semua'],
    'marker_bands' => [
        ['max' => 0, 'label' => '0 mahasiswa', 'color' => '#475569'],
        ['max' => 10, 'label' => '1–10 mahasiswa', 'color' => '#DC2626'],
        ['max' => 50, 'label' => '11–50 mahasiswa', 'color' => '#EAB308'],
        ['max' => 100, 'label' => '51–100 mahasiswa', 'color' => '#16A34A'],
        ['max' => null, 'label' => '>100 mahasiswa', 'color' => '#1D4ED8'],
    ],
];
