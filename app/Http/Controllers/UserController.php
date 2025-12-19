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
    // dd($request->all());
    // $data = $request->validated();
    //     $user = User::create([
    //         'name'=> $data['name'],
    //         'email'=>$data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);

    //     $token = $user->createToken('main')->plainTextToken;
    //      return response(compact('user', 'token'));

    $validated = $request->validated();

    $validated['password'] = Hash::make($validated['password']);

    $user = User::create($validated);

    Auth::login($user);

    $token = $user->createToken('api-token');

    return response()->json([
        'message' => 'user registered successfully!',
        'user' => new UserResource($user),
        'token' => $token->plainTextToken
    ], 201);
}

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where(['email' => $credentials['email']])->first();

        if (!$user || !Hash::check($credentials['password'], $user['password'])) {
            return response()->json(['message' => 'invalid Credentials']);
        }

        AuthSession::putUser($user);

        $token = $user->createToken('api-token');
        return response()->json([
            'message' => 'User Login successful',
            'user' => new UserResource($user),
            'token' =>  $token->plainTextToken
        ], 201);
    }

    public function index(){
        return UserResource::collection(
        User::query()->orderBy('id', 'desc')->paginate(10)
        );
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=> 'Logged out successfully']);
    }
}
