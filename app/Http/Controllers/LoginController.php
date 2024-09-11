<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();

            $result = [
                'user' => new UserResource($user),
                'token' => $user->createToken('authToken')->plainTextToken,
            ];

            return $this->sendResponse($result, 'User login successfully.');
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
    }
}
