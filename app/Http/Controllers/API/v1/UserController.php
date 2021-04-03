<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function store(CreateUserRequest $request)
    {
        $createdUser = User::create($request->input());
        Mail::to($createdUser)->queue(new Welcome($createdUser));

        return $createdUser;
    }
}
