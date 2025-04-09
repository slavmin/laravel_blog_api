<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Logout;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Revoke the user's current token...
        $request->user()->currentAccessToken()->delete();

        event(new Logout(config('defaults.guard'), $request->user()));

        return response()->json(['message' => 'Successfully logged out']);
    }
}
