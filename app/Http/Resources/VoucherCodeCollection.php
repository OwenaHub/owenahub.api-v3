<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherCodeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'voucherCodes' => $this->collection->map(function ($voucher) {
                return [
                    'id' => $voucher->id,
                    'code' => $voucher->code,
                    'status' => $voucher->status,
                    'price' => $voucher->price,
                    'issuedTo' => $voucher->issued_to,
                    'expiresAt' => $voucher->expires_at,
                ];
            }),
        ];
    }
}
