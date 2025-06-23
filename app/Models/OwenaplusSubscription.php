<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class OwenaplusSubscription extends Model
{
    use HasUlids;

    protected $fillable = [
        'user_id',
        'owenaplus_plan_id',
        'status',
        'started_at',
        'ends_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(OwenaplusPlan::class);
    }
    public function isActive()
    {
        return $this->status === 'active';
    }
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
    public function isExpired()
    {
        return $this->status === 'expired';
    }
}
