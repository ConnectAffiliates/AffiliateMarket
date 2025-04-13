<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(private AuthServiceInterface $authService) {}

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register([
            'email' => $request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role ?? 'affiliate'
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}