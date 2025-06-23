<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Validate Paystack secret header
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();
        $secret = config('services.paystack.secret_key');

        if (hash_hmac('sha512', $payload, $secret) !== $signature) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        Log::info('Paystack webhook event: ' . $event, $data);

        // Handle invoice payment success
        if ($event === 'invoice.payment_succeeded') {
            $email = $data['customer']['email'];
            $amount = $data['amount'] / 100;

            // Find user & subscription
            $user = User::where('email', $email)->first();
            if ($user) {
                $subscription = $user->subscription()->latest()->first();
                if ($subscription) {
                    $subscription->update([
                        'status' => 'active',
                        'ends_at' => Carbon::parse($subscription->ends_at)->addMonth(), // or based on plan
                        'next_billing_at' => now()->addMonth(),
                    ]);

                    Payment::create([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'type' => 'subscription',
                        'reference' => $data['reference'],
                        'status' => 'success',
                        'payment_method' => $data['channel'],
                        'metadata' => json_encode(['renewal' => true]),
                    ]);
                }
            }
        }

        // Handle failed payment
        if ($event === 'invoice.payment_failed') {
            // You can update subscription status to 'expired' or 'cancelled'
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
