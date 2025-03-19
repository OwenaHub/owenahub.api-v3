<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'display_picture',
        'biography',
        'account_type',
        'password',
    ];

    public function mentor_profile(): HasOne
    {
        return $this->hasOne(MentorProfile::class);
    }

    public function course_enrollment(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function user_lesson(): HasMany
    {
        return $this->hasMany(UserLesson::class);
    }

    public function work_experience(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function resume(): HasMany
    {
        return $this->hasMany(Resume::class);
    }

    public function portfolio_setting(): HasOne
    {
        return $this->hasOne(PortfolioSetting::class);
    }

    public function account_setting(): HasOne
    {
        return $this->hasOne(AccountSetting::class);
    }

    public function subscription(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
