<?php

namespace Features\Core\Database\Factories;

use Features\Core\Models\Account;
use Features\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'account_number' => fake()->numerify("###########################"),
            'user_id' => 1,
        ];
    }
}
