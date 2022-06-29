<?php

namespace Features\Core\Database\Factories;


use Carbon\Carbon;
use Features\Core\Models\Account;
use Features\Core\Models\CreditCart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditCartFactory extends Factory
{
    protected $model = CreditCart::class;

    public function definition()
    {
        return [
            'cart_number' => fake()->unique()->numerify('################'),
            'account_id'=> Account::factory(),
            'cvv2' => fake()->numerify("####"),
            'expired_at' => Carbon::now()->addYears(3),
        ];
    }
}
