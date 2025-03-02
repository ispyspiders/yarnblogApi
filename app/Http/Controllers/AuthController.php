<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Registrera användare
    public function register(Request $request)
    {
        $validatedUser = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required'
            ]
        );

        // Misslyckad validering
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validatedUser->errors()
            ], 401);
        }

        // Lyckad validering - lagra användare och returnera token
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201); // return response created
    }

    // Logga in användare
    public function login(Request $request)
    {
        $validatedUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        // Misslyckad validering
        if ($validatedUser->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validatedUser->errors()
            ], 401);
        }

        // Felaktig credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Failed credentials',
                'message' => 'Incorrect email and/or password'
            ], 401);
        }

        // Korrekt inloggning - returnera token
        $user = User::where('email', $request->email)->first();
        return response()->json([
            'message' => 'User logged in!',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'User logged out!'
        ];
        return response($response, 200);
    }
}
