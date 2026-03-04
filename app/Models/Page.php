<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUuids; // Aktifkan Auto UUID
    protected $fillable = ['title', 'slug', 'content', 'meta_description'];
    protected $casts = [
        'content' => 'array', 
    ];
}
