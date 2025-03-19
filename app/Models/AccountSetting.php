<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountSetting extends Model
{
    protected $fillable = [
        'preferred_currency',
        'country',
        'language',
        'allow_email_notifications'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
