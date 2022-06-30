<?php

namespace Features\Core\Http\V1\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'amount' => $this->amount,
            'is_completed' => $this->status,
            'creation_time' => $this->created_at->format('Y-m-d H:i:s'),
            'cart_number' => $this->credit_cart?->cart_number,
        ];
    }
}
