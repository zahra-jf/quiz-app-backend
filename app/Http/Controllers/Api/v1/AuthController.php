<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return $this->error([
                'status_code' => 402,
                'message' => 'Failed to create user',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'message' => 'user registered successfully, login please',
            'data' => [
                'user' => $user,
                'accessToken' => $token
            ],
        ]);
    }

    public function login(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) return $this->error([
            'status_code' => 404,
            'message' => "This user doesn't have register yet, please register first"
        ]);

        if (!Hash::check($request['password'], $user->password)) {
            return $this->error([
                'status_code' => 422,
                'message' => "Invalid Credentials."
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->update(['last_login' => now()]);
        return $this->success([
            'data' => [
                'user' => $user,
                'access_token' => $token,
            ],
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        //comment test
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

}
