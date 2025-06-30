<?php

namespace App\Observers;

use App\Models\OwenaplusSubscription;
use App\Notifications\Subscription\OwenaPlusSubscriptionStatus;

class OwenaPlusSubscriptionObserver
{
    /**
     * Handle the OwenaplusSubscription "created" event.
     */
    public function created(OwenaplusSubscription $owenaplusSubscription): void
    {
        $owenaplusSubscription->user->notify(
            new OwenaPlusSubscriptionStatus($owenaplusSubscription)
        );
    }

    /**
     * Handle the OwenaplusSubscription "updated" event.
     */
    public function updated(OwenaplusSubscription $owenaplusSubscription): void
    {
        $owenaplusSubscription->user->notify(
            new OwenaPlusSubscriptionStatus($owenaplusSubscription)
        );
    }

    /**
     * Handle the OwenaplusSubscription "deleted" event.
     */
    public function deleted(OwenaplusSubscription $owenaplusSubscription): void
    {
        //
    }

    /**
     * Handle the OwenaplusSubscription "restored" event.
     */
    public function restored(OwenaplusSubscription $owenaplusSubscription): void
    {
        //
    }

    /**
     * Handle the OwenaplusSubscription "force deleted" event.
     */
    public function forceDeleted(OwenaplusSubscription $owenaplusSubscription): void
    {
        //
    }
}
