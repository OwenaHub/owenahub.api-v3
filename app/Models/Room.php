<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    protected $fillable = [
        'name',
        'about',
        'meeting_link',
        'start_date',
        'end_date'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
