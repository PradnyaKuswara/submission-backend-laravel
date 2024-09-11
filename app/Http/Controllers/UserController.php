<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;

class UserController extends BaseController
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function index()
    {
        $users = $this->userInterface->all();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    public function find(User $user)
    {
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }

    public function store(UserRequest $request)
    {
        $result = $this->userInterface->create($request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new UserResource($result), 'User created successfully.', 201);
    }

    public function update(UserRequest $request, User $user)
    {
        $result = $this->userInterface->update($user, $request->validated());

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse(new UserResource($result), 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $result = $this->userInterface->delete($user);

        if (is_string($result)) {
            return $this->sendError($result, [], 400);
        }

        return $this->sendResponse($result, 'User deleted successfully.');
    }
}
