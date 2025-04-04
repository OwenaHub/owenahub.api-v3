<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherCodeCollection;
use App\Models\VoucherCode;
use Illuminate\Http\Request;

class VoucherCodeController extends Controller
{
    public function index(Request $request)
    {
        $mentor = $request->user()->mentor_profile;

        if (!$mentor) {
            return response()->json([
                'error' => 'User does not have a mentor profile'
            ], 404);
        }

        $voucher_codes = $mentor->voucher_code()->latest()->get();

        return new VoucherCodeCollection($voucher_codes);
    }

    public function store(Request $request)
    {
        $mentor = $request->user()->mentor_profile;

        if (!$mentor) {
            return response()->json([
                'error' => 'User does not have a mentor profile'
            ], 404);
        }

        $data = $request->validate([
            'issued_to' => 'email|nullable',
            'code' => 'required|min:10|max:10',
            'price' => 'numeric|nullable',
            'expires_at' => 'date|nullable'
        ]);

        $request->user()
            ->mentor_profile->voucher_code()->create($data);

        return response()->noContent();
    }

    public function destroy(VoucherCode $voucher_code)
    {
        try {
            $voucher_code->delete();
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ]);
        }
    }
}
