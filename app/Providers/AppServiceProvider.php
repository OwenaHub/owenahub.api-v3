<?php

namespace App\Providers;

use App\Models\OwenaplusSubscription;
use App\Models\TaskSubmission;
use App\Observers\OwenaPlusSubscriptionObserver;
use App\Observers\TaskFeedbackObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        JsonResource::withoutWrapping();

        TaskSubmission::observe(TaskFeedbackObserver::class);
        OwenaplusSubscription::observe(OwenaPlusSubscriptionObserver::class);
    }
}
