<?php

namespace App\Http\Controllers\PortfolioAccount;

use Illuminate\Support\Str;
use App\Models\PortfolioPlans;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\UserPortfolioSubscription;
use App\Http\Requests\Portfolio\PortfolioAccountRequest;

class CreatePortfolioAccountController extends Controller
{
    public function store(PortfolioAccountRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        DB::beginTransaction();

        try {
            // 1. Find or assign free plan
            $free_plan = PortfolioPlans::where('name', 'basic')->firstOrFail();

            // 2. Create a subscription if one doesn't already exist
            UserPortfolioSubscription::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'portfolio_plan_id' => $free_plan->id
                ],
                [
                    'is_active' => true,
                    'started_at' => now(),
                    'ends_at' => null // Set to null for free plans.
                    // 'ends_at' => now()->addMonth()
                ]
            );

            if (!$data['slug']) {
                $slug = Str::slug($user->name) . '-' . Str::random(4); // unique-ish
                $data['slug'] = $slug;
            };

            $user->portfolio_account->create($data);

            DB::commit();

            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
