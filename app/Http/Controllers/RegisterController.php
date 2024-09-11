<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends BaseController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $result = [
            'user' => $user,
            'token' => $user->createToken('authToken')->plainTextToken,
        ];

        return $this->sendResponse($result, 'User register successfully.', 201);
    }
}
