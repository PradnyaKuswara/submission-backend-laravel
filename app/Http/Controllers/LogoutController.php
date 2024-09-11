<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $response = response()->json([
            'message' => 'User logout successfully.',
        ], 200);

        $request->user()->currentAccessToken()->delete();

        return $response;
    }
}
