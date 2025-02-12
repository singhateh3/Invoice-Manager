<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use AuthSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        Auth::login($user);
        $token = $user->createToken('api-token');
        return response()->json(['message' => 'user registered successfully!', 'User' => new UserResource($user), 'token' => $token->plainTextToken], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where(['email' => $credentials['email']])->first();

        if (!$user && !Hash::check($credentials['password'], $user['password'])) {
            return response()->json(['message' => 'invalid Credentials']);
        }

        AuthSession::putUser($user);

        $token = $user->createToken('api-token');
        return response()->json([
            'message' => 'User Login successful',
            'User' => new UserResource($user),
            'token' =>  $token->plainTextToken
        ], 201);
    }
}
