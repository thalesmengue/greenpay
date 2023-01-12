<?php

namespace App\Services;



use App\Events\Registered;
use App\Http\Requests\LoginAuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    public function register($data): JsonResponse
    {
        $document = $data['document'];

        $role = match (strlen($document)) {
            11 => 'common',
            14 => 'shopkeeper'
        };

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'document' => $document,
            'role' => $role,
        ]);

        event(new Registered($user));

        $token = $user->createToken('access_token')->accessToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login($data): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = request()->user();

        $tokenResult = $user->createToken('access_token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'data' => $user,
            'access_token' => $tokenResult->accessToken
        ], Response::HTTP_OK);
    }
}
