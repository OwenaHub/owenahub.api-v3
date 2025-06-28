<?php

namespace App\Notifications\Task;

use App\Models\TaskSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubmission extends Notification
{
    use Queueable;

    protected $submission;
    protected $recipient;

    /**
     * Create a new notification instance.
     */
    public function __construct(TaskSubmission $taskSubmission, string $recipientType)
    {
        $this->submission = $taskSubmission;
        $this->recipient = $recipientType;
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
        if ($this->recipient === 'self') {
            return (new MailMessage)
                ->subject('Task Submitted Successfully')
                ->line('Your task has been submitted successfully.')
                ->action('View Submission', url('/tasks/' . $this->submission->id));
        }

        return (new MailMessage)
            ->subject('A Student Submitted a Task')
            ->greeting("{$this->submission->user->name} has submitted a task for your review")
            ->action('Review Submission', url('/account/mentor-profile/task-submissions/' . $this->submission->id))
            ->line('Try to respond within 24 hours');
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
