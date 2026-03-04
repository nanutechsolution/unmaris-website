<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids; // Aktifkan Auto UUID


    protected $fillable = ['name', 'slug'];

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
