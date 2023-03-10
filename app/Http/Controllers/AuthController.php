<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $auth
    )
    {
    }

    public function register(RegisterAuthRequest $request): JsonResponse
    {
        return $this->auth->register($request->validated());
    }

    public function login(LoginAuthRequest $request): JsonResponse
    {
        return $this->auth->login($request->validated());
    }
}
