<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class News extends Model
{
    use HasUuids, LogsActivity;  


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'category_id', 'is_published', 'published_at'])
            ->logOnlyDirty()
            ->useLogName('Berita');
    }

    protected $fillable = ['category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'is_published', 'published_at', 'views', 'shares'];
    protected $casts = ['published_at' => 'datetime', 'is_published' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
