<?php

namespace Features\Core\Http\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'is_completed' => $this->status,
        ];
    }
}
