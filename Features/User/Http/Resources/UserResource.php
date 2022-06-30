<?php

namespace Features\User\Http\Resources;

use Features\Core\Http\V1\Resources\TransactionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'transactions' => TransactionResource::collection($this->transactions),
        ];
    }
}
