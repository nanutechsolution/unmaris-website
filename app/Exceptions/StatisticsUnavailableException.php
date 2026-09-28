<?php

namespace App\Exceptions;

use Exception;

/**
 * Dilempar ketika statistik agregat dari SIAKAD tidak dapat diambil atau
 * bentuk responsnya tidak sesuai kontrak. Pesan tidak pernah memuat isi
 * respons, URL, atau data pribadi mahasiswa.
 */
class StatisticsUnavailableException extends Exception
{
    public function __construct(
        string $message = 'Statistik mahasiswa sedang tidak tersedia.',
        private readonly string $reason = 'unknown',
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
