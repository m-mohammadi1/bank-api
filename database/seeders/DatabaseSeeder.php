<?php

namespace Database\Seeders;

use Features\Core\Models\Account;
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
         User::factory()
             ->has(Account::factory()->count(2))
             ->create();
    }
}
