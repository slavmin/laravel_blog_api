<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Enums\Roles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'email|required|unique:users,email',
            'name' => 'required|string|min:4|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole(Roles::READER->value);

        event(new Registered($user));

        return response()->json(['message' => 'Registered successfully']);
    }
}
