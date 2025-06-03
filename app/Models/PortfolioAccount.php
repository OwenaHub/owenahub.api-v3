<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioAccount extends Model
{
    protected $fillable = [
        'about',
        'theme',
        'slug',
        'x_url',
        'github_url',
        'linkedin_url',
        'website',
        'meta',
        'location',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
