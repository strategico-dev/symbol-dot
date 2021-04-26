<?php


namespace App\Services;

use App\Models\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * @param array $data
     * @return mixed
     */
    public static function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $createdUser = User::create($data);

        Mail::to($createdUser)->queue(new Welcome($createdUser));

        return $createdUser;
    }
}
