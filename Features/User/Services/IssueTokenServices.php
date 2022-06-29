<?php

namespace Features\User\Services;

use Features\User\Models\User;
use Laravel\Sanctum\NewAccessToken;

class IssueTokenServices
{

    public static function run(string $phone_number, string $password): NewAccessToken
    {
        abort_if(
            !auth()->attempt(['phone_number' => $phone_number, 'password' => $password]),
            422,
            __('Invalid Phone or Password.')
        );

        $user = User::query()
            ->where('phone_number', $phone_number)
            ->firstOrFail();

        $user->tokens()->delete();
        return $user->createToken('auth-token');
    }

}
