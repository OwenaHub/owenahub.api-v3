<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OwenaplusPlan;
use App\Models\OwenaplusSubscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VerifyPaystackPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'reference' => ['required', 'min:16', 'max:16', 'string']
        ]);

        $reference = $request->input('reference');

        if (Payment::where('transaction_reference', $reference)->exists()) {
            return response()->json(['error' => 'Reference number already exists in our record'], 409);
        }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

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
            return response()->json(['error' => 'No plan found'], 404);
        }

        // Begin transaction
        DB::beginTransaction();

        try {
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

            DB::commit();

            return response()->json([
                'message' => 'Payment verified'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while processing the payment.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
