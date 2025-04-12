<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'id' => $request->id ?? \Illuminate\Support\Str::uuid(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_active' => true
        ]);

        // Assign default role based on request or configuration
        $role = $request->role ?? 'affiliate';
        $user->assignRole($role);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}