<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPortfolioSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'portfolio_plan_id',
        'is_active',
        'started_at',
        'ends_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolio_plan()
    {
        return $this->belongsTo(PortfolioPlans::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('is_active', 'expired');
    }

    public function scopeCancelled($query)
    {
        return $query->where('is_active', 'cancelled');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
