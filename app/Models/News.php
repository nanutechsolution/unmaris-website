<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasUuids; // Aktifkan Auto UUID

    protected $fillable = ['category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'is_published', 'published_at'];
    protected $casts = ['published_at' => 'datetime', 'is_published' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
