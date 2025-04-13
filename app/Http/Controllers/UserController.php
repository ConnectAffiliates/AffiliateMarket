<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserServiceInterface $userService) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        
        $users = $this->userService->getAllUsers([
            'role' => $request->role,
            'per_page' => $request->per_page ?? 15
        ]);

        return response()->json($users);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        $this->authorize('view', $user);
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        $this->authorize('update', $user);

        $updatedUser = $this->userService->updateUser($id, $request->validated());
        return response()->json($updatedUser);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        $this->authorize('delete', $user);
        
        $this->userService->deleteUser($id);
        return response()->json(null, 204);
    }
}