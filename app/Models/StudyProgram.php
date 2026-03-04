<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasUuids; // Aktifkan Auto UUID
      protected $fillable = [
        'faculty_id', 'name', 'slug', 'degree', 'accreditation', 'description',
        'vision', 'mission', 'career_prospects' 
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
