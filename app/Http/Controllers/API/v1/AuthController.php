<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    #Route::post('/api/v1/auth/login')
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if(!$token = auth()->attempt($credentials))
        {
            return response()->json([
                'message' => 'Bad credentials'
            ], 401);
        }

        return $this->tokenize($token);
    }

    #Route::get('/api/v1/auth/me')
    public function me()
    {
        return response()->json(auth()->user());
    }

    #Route::post('/api/v1/auth/refresh')
    public function refresh()
    {
        return $this->tokenize(auth()->refresh());
    }

    #Route::post('/api/v1/auth/logout')
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
