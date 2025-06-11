<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasUlids;

    protected $fillable = [
        'title',
        'about',
        'tags',
        'learning_goals',
        'requirements',
        'description',
        'thumbnail',
        'start_date',
        'price',
        'level',
        'status'
    ];

    public function mentor_profile(): BelongsTo
    {
        return $this->belongsTo(MentorProfile::class);
    }

    public function course_enrollment(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function module(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function course_session(): HasMany
    {
        return $this->hasMany(CourseSession::class);
    }
}
