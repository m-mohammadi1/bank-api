<?php

namespace Features\User\Tests\Feature;

use Features\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    Use RefreshDatabase;

    public function test_token_issues_successfully()
    {
        User::factory()
            ->createOne([
                'phone_number' => '09145687353',
                'password' => bcrypt('12345678')
            ]);

        $this
            ->postJson(route('login'), [
                'phone_number' => '09145687353',
                'password' => '12345678'
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has('token'));
    }

    public function test_token_wont_be_issuing_with_incorrect_info()
    {
        User::factory()
            ->createOne([
                'phone_number' => '09145687353',
                'password' => bcrypt('12345678')
            ]);

        $this
            ->postJson(route('login'), [
                'phone_number' => '54165465121',
                'password' => '12345678'
            ])
            ->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json->missing('token')->etc());
    }
}
