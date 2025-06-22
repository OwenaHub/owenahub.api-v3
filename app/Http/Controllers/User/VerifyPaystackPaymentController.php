<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OwenaplusPlan;
use App\Models\OwenaplusSubscription;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VerifyPaystackPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $reference = $request->input('reference');

        if (!$reference) {
            return response()->json(['error' => 'No reference provided'], 400);
        }

        // Verify with Paystack
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        Log::info($response->json());

        $data = $response->json();

        if (!$response->ok()) {
            return response()->json([
                'error' => [
                    'message' => $data['message'] ?? 'Unknown error',
                    'details' => $data['meta'] ?? 'Something went wrong'
                ]
            ], 400);
        }

        $amount_paid = $data['data']['amount'] / 100; // kobo to naira
        $payment_mtd = $data['data']['channel'];

        $plan = OwenaplusPlan::first();

        if (!$plan) {
            return response()->json(['error' => 'No plan found'], 500);
        }

        // Create subscription
        $subscription = OwenaplusSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        // Record transaction
        Payment::create([
            'user_id' => $user->id,
            'amount' => $amount_paid,
            'type' => 'subscription',
            'reference' => $reference,
            'status' => 'success',
            'payment_method' => $payment_mtd,
            'metadata' => json_encode([
                'plan_id' => $plan->id,
                'subscription_id' => $subscription->id,
            ]),
        ]);

        return response()->json([
            'message' => 'Payment verified'
        ], 200);
    }
}
