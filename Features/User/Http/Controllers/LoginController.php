<?php

namespace Features\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Features\User\Http\Requests\LoginRequest;
use Features\User\Services\IssueTokenServices;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        $token = IssueTokenServices::run($request->input('phone_number'), $request->input('password'));

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
}
