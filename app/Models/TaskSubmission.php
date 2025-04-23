<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = [
        'user_id',
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
}
