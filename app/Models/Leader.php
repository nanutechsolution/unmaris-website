<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'position',
        'image',
        'order',
        'is_active',
    ];
}
