<?php

namespace App\Listeners;

use App\Events\TaskSubmitted;
use App\Notifications\Task\NewSubmission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskSubmissionNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskSubmitted $event): void
    {
        $submission = $event->taskSubmission;

        // Notify the user who submitted
        $submission->user->notify(new NewSubmission($submission, 'self'));

        // Notify the course creator (mentor)
        $course_creator = $submission
            ->task
            ->lesson
            ->module
            ->course
            ->mentor_profile
            ->user;
        $course_creator->notify(new NewSubmission($submission, 'mentor'));
    }
}
