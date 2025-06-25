<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'amount' => $this->amount,
            'transactionReference' => $this->transaction_reference,
            'amount' => $this->amount,
            'purchaseItem' => $this->purchase_item,
            'status' => $this->status,
            'paymentGateway' => $this->payment_gateway,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
