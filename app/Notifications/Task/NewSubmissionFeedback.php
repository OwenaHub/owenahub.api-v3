<?php

namespace App\Notifications\Task;

use App\Models\TaskSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewSubmissionFeedback extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public TaskSubmission $submission)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Feedback On Your Submission!')
            ->line('Hello!, Your mentor has given feedback on your task submission.')
            ->line('Status: ' . $this->submission->status)
            ->line('Feedback: ' . Str::limit($this->submission->feedback))
            ->action('Review Submission', url('/tasks' . $this->submission->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
