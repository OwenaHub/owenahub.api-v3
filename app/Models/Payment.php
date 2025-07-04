<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'transaction_reference',
        'amount',
        'metadata',
        'purchase_item', // 'course', 'portfolio', 'subscription'
        'currency',
        'status',
        'payment_gateway'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
