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
        'profile_picture',
        'title',
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

    public function course_purchase(): HasMany
    {
        return $this->hasMany(CoursePurchase::class);
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
        return $this->hasMany(PortfolioWorkExperience::class);
    }

    public function project(): HasMany
    {
        return $this->hasMany(PortfolioProject::class);
    }

    public function portfolio_account(): HasOne
    {
        return $this->hasOne(PortfolioAccount::class);
    }

    public function account_setting(): HasOne
    {
        return $this->hasOne(AccountSetting::class);
    }

    public function portfolio_subscription(): HasOne
    {
        return $this->hasOne(UserPortfolioSubscription::class);
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function task_submission(): HasMany
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function owenaplus_subscription(): HasOne
    {
        return $this->hasOne(OwenaplusSubscription::class);
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
