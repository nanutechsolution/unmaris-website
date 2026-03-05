<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PopupPromo extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'subtitle', 'image', 'description', 
        'button_text', 'button_url', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
