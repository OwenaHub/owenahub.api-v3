<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'video_url',
        'position',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
