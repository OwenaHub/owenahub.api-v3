<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OwenaplusPlan;
use App\Models\OwenaplusSubscription;
use App\Models\Payment;
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

        // Log::info("Verify payment response:", $response->json());

        $data = $response->json();

        if (!$response->ok()) {
            return response()->json([
                'error' => [
                    'message' => $data['message'] ?? 'Unknown error',
                    'details' => $data['meta'] ?? 'Something went wrong'
                ]
            ], 400);
        }

        if (!isset($data['data']['amount'], $data['data']['channel'], $data['data']['currency'])) {
            return response()->json(['error' => 'Invalid payment data received from Paystack'], 500);
        }

        $amount_paid = $data['data']['amount'] / 100; // kobo to naira

        $plan = OwenaplusPlan::first();

        if (!$plan) {
            return response()->json(['error' => 'No plan found'], 500);
        }

        // Create or update subscription
        $subscription = OwenaplusSubscription::updateOrCreate(
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

        // Create or update payment record
        Payment::updateOrCreate(
            [
                'transaction_reference' => $reference,
                'user_id' => $user->id,
            ],
            [
                'amount' => $amount_paid,
                'purchase_item' => 'subscription',
                'status' => 'successful',
                'payment_gateway' => 'paystack',
                'metadata' => json_encode([
                    'plan_id' => $plan->id,
                    'subscription_id' => $subscription->id,
                    'payment_channel' => $data['data']['channel'],
                    'currency' => $data['data']['currency'],
                ]),
            ]
        );

        return response()->json([
            'message' => 'Payment verified'
        ], 200);
    }
}
