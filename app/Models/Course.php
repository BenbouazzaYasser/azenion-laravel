<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'academy_courses';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }
}
