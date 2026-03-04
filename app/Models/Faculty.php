<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasUuids; // Aktifkan Auto UUID

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'vision',
        'mission',
        'email',
        'phone' 
    ];

    public function studyPrograms(): HasMany
    {
        return $this->hasMany(StudyProgram::class);
    }
}
