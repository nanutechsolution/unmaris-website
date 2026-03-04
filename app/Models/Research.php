<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Research extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'title', 'slug', 'type', 'author', 'abstract', 
        'link_url', 'file_path', 'publication_date', 'is_active'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'type', 'author'])
            ->logOnlyDirty()
            ->useLogName('Penelitian & LPPM');
    }
}
