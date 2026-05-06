<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function storeUser(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'user'    => $user->only(['id', 'name', 'email']),
        ], 201);
    }

    public function showUser(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'User retrived successfully',
            'data'    => $user->only(['id', 'name', 'email', 'created_at']),
        ]);
    }

    public function updateUser(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'data'    => $user->only(['id', 'name', 'email']),
        ]);
    }

    public function deleteUser(string $id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()){
            return response()->json([
            'message' => 'User is already deleted',
            ],422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
    
    public function restoreUser(string $id): JsonResponse
    {
        $user = User::withTrashed()->find($id);

        if (!$user->trashed()){
            return response()->json([
            'message' => 'User is not deleted',
            ],409);
        }

        $user->restore();

        return response()->json([
            'message' => 'User restored successfully',
            'data'    => $user->only(['id', 'name', 'email','created_at']),
        ]);
    }
}
