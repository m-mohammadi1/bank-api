<?php

namespace Features\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    public function definition()
    {
        // account_number
        //user_id
        return [
            'account_number' => fake()->numerify("###########################"),
            'user_id' => 1,
        ];
    }
}
