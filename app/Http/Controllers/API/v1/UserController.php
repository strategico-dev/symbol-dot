<?php

namespace App\Http\Controllers\API\v1;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    #Route::post('/api/v1/users')
    public function store(CreateUserRequest $request)
    {
        return UserService::create($request->input());
    }
}
