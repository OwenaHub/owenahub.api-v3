<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentRecordResource;
use Illuminate\Http\Request;

class GetPaymentRecordsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $payments = $user->payment()->latest()->get();

        return PaymentRecordResource::collection($payments);
    }
}
