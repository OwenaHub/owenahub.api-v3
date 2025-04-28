<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VoucherCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RedeemVoucherCodeController extends Controller
{
    public static function update(Request $request, $price): JsonResponse
    {
        $data = $request->validate([
            'code' => 'required|exists:voucher_codes,code',
        ]);

        $voucher = VoucherCode::where('code', $data['code'])->first();

        if (!$voucher) {
            return response()->json([
                'error' => 'Invalid voucher code.'
            ], 400);
        }

        // Check if voucher is already redeemed
        if ($voucher->status !== "unused") {
            return response()->json([
                'error' => 'Voucher code is already redeemed.'
            ], 400);
        }

        // Check if voucher price matches
        if (($voucher->price != $price) && ($voucher->price != 0.00)) {
            return response()->json([
                'error' => 'Voucher code does not match the provided price.'
            ], 400);
        }

        // Check if the voucher belongs to a specific user
        if (!empty($voucher->issued_to) && $voucher->issued_to !== $request->user()->email) {
            return response()->json([
                'error' => 'This voucher belongs to another user.'
            ], 400);
        }

        try {
            $voucher->update(['status' => 'redeemed']);
            return response()->json([
                'message' => 'Voucher successfully redeemed.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
