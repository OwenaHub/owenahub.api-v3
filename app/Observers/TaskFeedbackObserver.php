<?php

namespace App\Observers;

use App\Models\TaskSubmission;
use App\Notifications\Task\NewSubmissionFeedback;

class TaskFeedbackObserver
{
    /**
     * Handle the TaskSubmission "created" event.
     */
    public function created(TaskSubmission $taskSubmission): void
    {
        //
    }

    /**
     * Handle the TaskSubmission "updated" event.
     */
    public function updated(TaskSubmission $taskSubmission): void
    {
        if (
            ($taskSubmission->isDirty('status') || $taskSubmission->isDirty('feedback')) &&
            $taskSubmission->status !== null && $taskSubmission->feedback !== null
        ) {
            $taskSubmission->user->notify(new NewSubmissionFeedback($taskSubmission));
        }
    }

    /**
     * Handle the TaskSubmission "deleted" event.
     */
    public function deleted(TaskSubmission $taskSubmission): void
    {
        //
    }

    /**
     * Handle the TaskSubmission "restored" event.
     */
    public function restored(TaskSubmission $taskSubmission): void
    {
        //
    }

    /**
     * Handle the TaskSubmission "force deleted" event.
     */
    public function forceDeleted(TaskSubmission $taskSubmission): void
    {
        //
    }
}
