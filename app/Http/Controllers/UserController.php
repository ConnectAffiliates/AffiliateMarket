<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::query()
            ->when($request->role, function ($query, $role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->paginate($request->per_page ?? 15);

        return response()->json($users);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);
        return response()->json($user->load('roles', 'permissions'));
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        return response()->json($user->refresh()->load('roles', 'permissions'));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(null, 204);
    }
}