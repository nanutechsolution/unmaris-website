<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StudyProgram extends Model
{
    use HasUuids, LogsActivity;
    protected $fillable = [
        'faculty_id',
        'name',
        'slug',
        'degree',
        'accreditation',
        'description',
        'vision',
        'mission',
        'career_prospects'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'faculty_id', 'degree', 'accreditation'])
            ->logOnlyDirty()
            ->useLogName('Program Studi');
    }
}
