<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $jwt = JWTAuth::fromUser($user);

        return response()->json([
            'jwt' => $jwt
        ], 201);
    }

    public function login(Request $request)
    {
        // get only email and password from the payload
        $credentials = $request->only('email', 'password');

        try {
            if (!JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ]);
            }

            // If credentials were valid get user
            $user = auth()->user();
            $jwt = JWTAuth::claims([
                'userId' => $user->id,
                'userEmail' => $user->email
            ])->fromUser($user);

            return response()->json([
                'jwt' => $jwt
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Error occurred while creating token. Try again later.'
            ]);
        }
    }

    public function me()
    {
        // ->user() tries to parse the token from the request (Authorization: Bearer <TOKEN> header).
        // If a token is present it will: 
        // Decode the JWT, 
        // Validate it (check signature, expiration, etc)
        // Load the user from the database using the user ID in the token’s payload
        return response()->json(auth('api')->user()); // Use api auth guard
    }

    public function refresh()
    {
        return auth('api')->refresh();
    }

    // User logout
    public function logout()
    {
        auth('api')->logout(); // Invalidate token
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function someMethod(Request $request)
    {
        try {
            // Check if user is authenticated
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or not provided'], 401);
        }

        // Token is valid, $user is the authenticated user
        return response()->json([
            'message' => 'Valid token'
        ]);
    }
}
