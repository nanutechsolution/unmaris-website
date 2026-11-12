<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Faculty extends Model
{
    use HasUuids , LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'struktur_organisasi',
        'document_path',
        'document_title',
        'vision',
        'mission',
        'email',
        'phone' 
    ];

    public function studyPrograms(): HasMany
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'description', 'struktur_organisasi', 'document_path', 'document_title', 'vision', 'mission', 'email', 'phone'])
            ->logOnlyDirty()
            ->useLogName('Fakultas');
    }
}
