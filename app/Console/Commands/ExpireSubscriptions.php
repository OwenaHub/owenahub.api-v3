<?php

namespace App\Console\Commands;

use App\Models\OwenaplusSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark all expired subscriptions as expired in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = OwenaplusSubscription::where('status', 'active')
            ->where('ends_at', '<', Carbon::now())
            ->update(['status' => 'expired']);

        $this->info("Expired $expired subscriptions.");
    }
}
