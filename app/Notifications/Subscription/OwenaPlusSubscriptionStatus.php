<?php

namespace App\Notifications\Subscription;

use App\Models\OwenaplusSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwenaPlusSubscriptionStatus extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public OwenaplusSubscription $subscription) {}

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
            ->subject('OwenaPlus Subscription')
            ->greeting("Hello " . explode(' ', trim($this->subscription->user->name))[0])
            ->line("Your subscription to OwenaPlus is now " . $this->subscription->status)
            ->action('Go to OwenaHub', url('/'))
            ->line('Thank you for using OwenaHub 💛');
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
