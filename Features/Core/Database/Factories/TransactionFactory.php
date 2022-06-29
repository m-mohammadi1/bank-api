<?php

namespace Features\Core\Database\Factories;


use Features\Core\Models\CreditCart;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition()
    {
        return [
            'amount' => fake()->numberBetween(1000000, 1000000000),
            'cart_id' => CreditCart::factory(),
            'status' => fake()->boolean(70),
        ];
    }
}
