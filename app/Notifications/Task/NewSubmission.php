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
                ->greeting("Hello " . explode(' ', trim($this->submission->user->name))[0])
                ->line('Your task has been submitted successfully to your mentor.')
                ->line('Expect a feedback within 24 hours of submitting your task, so keep an eye on your inbox.')
                ->action('View Submission', url('/tasks/' . $this->submission->id))
                ->line('Thank you for using OwenaHub 💛');
        }

        return (new MailMessage)
            ->subject('A Student Submitted a Task')
            ->line("{$this->submission->user->name} has submitted a task for your review")
            ->line('Try to respond within 24 hours')
            ->action('Review Submission', url('/account/mentor-profile/task-submissions/' . $this->submission->id));
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
