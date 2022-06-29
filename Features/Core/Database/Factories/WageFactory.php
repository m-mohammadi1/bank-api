<?php

namespace Features\Core\Database\Factories;

use Features\Core\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class WageFactory extends Factory
{

    public function definition()
    {
        return [
            'amount' => fake()->numberBetween(1000000, 1000000000),
            'transaction_id' => Transaction::factory(),
        ];
    }
}
