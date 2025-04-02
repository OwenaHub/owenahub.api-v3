<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoucherCode extends Model
{
    protected $fillable = [
        'issued_to',
        'code',
        'price',
        'status',
        'expires_at',
    ];

    public function mentor_profile(): BelongsTo
    {
        return $this->belongsTo(MentorProfile::class);
    }
}
