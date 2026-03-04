<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'provider',
        'description',
        'requirements',
        'benefits',
        'start_date',
        'end_date',
        'registration_url',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Helper untuk mengecek apakah beasiswa masih buka
    public function getIsOpenAttribute(): bool
    {
        if (!$this->is_active) return false;
        if (!$this->end_date) return true; // Jika tidak ada batas waktu
        return $this->end_date->isFuture() || $this->end_date->isToday();
    }
}
