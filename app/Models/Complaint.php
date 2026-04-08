<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory, HasUuids;

    /**
     * Skema Anda menggunakan char(36) untuk ID
     */
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'ticket_number',
        'name',
        'email',
        'phone',
        'category',
        'subject',
        'content',
        'attachment',
        'status',
        'admin_response',
    ];

    protected static function booted()
    {
        static::creating(function ($complaint) {
            // Generate Ticket Number
            $complaint->ticket_number = 'ADU-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        });

        static::updating(function ($complaint) {
            $original = $complaint->getOriginal();

            // Field yang tidak boleh diubah oleh admin
            $lockedFields = [
                'ticket_number',
                'name',
                'email',
                'phone',
                'category',
                'subject',
                'content',
                'attachment',
            ];

            foreach ($lockedFields as $field) {
                $complaint->$field = $original[$field];
            }
        });
    }

    /**
     * Casting untuk mempermudah manipulasi data
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
