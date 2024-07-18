<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->toJson(), 'status' => 400];
        }

        $user = $this->userRepository->create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        return ['data' => $user, 'status' => 201];
    }

    public function login(array $credentials): array
    {
        if (! $token = auth()->attempt($credentials)) {
            return ['data' => ['error' => 'Unauthorized'], 'status' => 401];
        }

        return ['data' => $this->respondWithToken($token), 'status' => 200];
    }

    public function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}
