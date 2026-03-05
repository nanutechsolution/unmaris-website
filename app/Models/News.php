<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Tags\HasTags;

class News extends Model
{
    use HasUuids, LogsActivity, HasTags;

    // /**
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'tags' => 'array',
    //     ];
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'category_id', 'is_published', 'published_at'])
            ->logOnlyDirty()
            ->useLogName('Berita');
    }

    protected $fillable = ['category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'video_url', 'is_published', 'published_at', 'views', 'shares'];
    protected $casts = ['published_at' => 'datetime', 'is_published' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
