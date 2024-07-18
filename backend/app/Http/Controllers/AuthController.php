<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Register a User.
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        $data = request()->all();
        $result = $this->authService->register($data);

        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');
        $result = $this->authService->login($credentials);

        return response()->json($result['data'], $result['status']);

    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json($this->authService->respondWithToken(auth()->refresh()));
    }
}
