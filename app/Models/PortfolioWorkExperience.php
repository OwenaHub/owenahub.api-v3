<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioWorkExperience extends Model
{
    protected $fillable = [
        'company',
        'role',
        'start_date',
        'end_date',
        'description'
    ];

    public function portfolio_account(): BelongsTo
    {
        return $this->belongsTo(PortfolioAccount::class);
    }
}
