<?php

namespace Features\Core\Http\V1\Controllers;

use Carbon\Carbon;
use Features\Core\Models\CreditCart;
use Features\Core\Models\Transaction;
use Features\User\Http\Resources\UserResource;
use Features\User\Models\User;
use Illuminate\Http\Request;

class UserTransactionsController
{

    public function getTransactions(Request $request)
    {
        $users = User::query()
            ->with('transactions')
            ->withCount(
                ['transactions' => function ($q) {
                    $q->where('transactions.created_at', '>', Carbon::now()->subMinutes(120));
                }]
            )
            ->orderByDesc('transactions_count')
            ->limit(3)
            ->get();


        return UserResource::collection($users);
    }

}
