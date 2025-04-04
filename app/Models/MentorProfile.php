<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MentorProfile extends Model
{
    protected $fillable = [
        'status',
        'is_verified',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function voucher_code(): HasMany
    {
        return $this->hasMany(VoucherCode::class);
    }
}
