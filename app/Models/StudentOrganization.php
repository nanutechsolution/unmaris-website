<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StudentOrganization extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'logo',
        'leader_name', 'social_media_link', 'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
