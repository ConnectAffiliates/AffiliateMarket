<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private AuthServiceInterface $authService) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->only('email', 'password'));
            return response()->json($token);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 401);
        }
    }
}