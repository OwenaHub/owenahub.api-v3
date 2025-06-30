<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OwenaplusPlan;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserOwenaplusSubscriptionController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $request->validate([
            'status' => ['required', 'in:active,cancelled,expired']
        ]);

        $status = $request->input('status');

        if ($status === 'active') {
            $plan = OwenaplusPlan::first();

            $user->owenaplus_subscription()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'owenaplus_plan_id' => $plan->id,
                ],
                [
                    'status' => 'active',
                    'started_at' => now(),
                    'ends_at' => now()->addMonth(),
                ]
            );
        } else {
            $subscription = $user->owenaplus_subscription()->latest()->first();
            if ($subscription) {
                $subscription->update([
                    'status' => $status,
                    'ends_at' => now(),
                ]);
            }
        }
    }
}
