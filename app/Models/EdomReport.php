<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EdomReport extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'study_program_id',
        'title',
        'academic_year',
        'semester',
        'description',
        'file_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        $semester = filled($this->semester) ? 'Semester '.$this->semester : null;
        $year = filled($this->academic_year) ? 'Tahun Akademik '.$this->academic_year : null;

        return collect([$semester, $year])->filter()->implode(' · ');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['study_program_id', 'title', 'academic_year', 'semester', 'description', 'file_path', 'is_active'])
            ->logOnlyDirty()
            ->useLogName('Laporan EDOM');
    }
}
