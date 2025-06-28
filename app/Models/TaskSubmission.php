<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class TaskSubmission extends Model
{
    use HasUlids, Notifiable;

    protected $fillable = [
        'task_id',
        'content',
        'feedback',
        'file_url',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
