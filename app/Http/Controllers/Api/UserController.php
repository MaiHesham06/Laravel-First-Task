<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $users = User::paginate(10);

        return $this->success( 
            UserResource::collection($users),    
            'Users retrieved successfully'
        );
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return $this->created(
            new UserResource($user),
            'User created successfully' 
        );
    }

    public function show(User $user): JsonResponse
    {
        return $this->success( 
            new UserResource($user),
            'User retrived successfully'   
        );
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return $this->success(
            new UserResource($user), 
            'User Updated Successfully'
        );
    }

    public function destroy(User $user): JsonResponse
    {
        $user->tokens()->delete();
        $user->delete();

        return  $this->ok(
            'User deleted successfully'
        );
    }
    
    public function restore(User $user): JsonResponse
    {
        if (!$user->trashed())  
        {
            return $this->error(
                'User is not deleted', 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user->restore();

        return $this->success(
            new UserResource($user), 
            'User Restored Successfully'
        );
    }
}
