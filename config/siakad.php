<?php

return [
    'base_url' => env('SIAKAD_API_BASE_URL', 'https://siakad.unmarissumba.ac.id/api/v1'),
    'connect_timeout' => (int) env('SIAKAD_CONNECT_TIMEOUT', 2),
    'timeout' => (int) env('SIAKAD_TIMEOUT', 5),
    'cache_ttl' => (int) env('SIAKAD_CACHE_TTL', 600),
    'cache_namespace' => 'siakad.statistik.v1',
    'levels' => ['provinsi', 'kabupaten', 'kecamatan', 'desa'],
    'statuses' => ['aktif', 'semua'],
];
