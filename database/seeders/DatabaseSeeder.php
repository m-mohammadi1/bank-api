<?php

namespace Database\Seeders;

use Features\Core\Models\Account;
use Features\Core\Models\CreditCart;
use Features\Core\Models\Transaction;
use Features\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $randNumber = rand(1, 10);
            User::factory()
                ->has(
                    Account::factory()
                        ->has(CreditCart::factory()
                            ->has(
                                Transaction::factory()
                                    ->count($randNumber)
                            )
                            ->state(function (array $attrbutes, Account $account) {
                                return [
                                    'account_id' => $account->id,
                                    'user_id' => $account->user_id
                                ];
                            })
                            ->count(2), 'credit_carts')
                        ->count(10)
                )
                ->createOne();
        }

    }
}
