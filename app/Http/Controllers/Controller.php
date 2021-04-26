<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Tokenizer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use Tokenizer, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var User
     */
    private User $authorizedUser;

    public function __construct()
    {
        $this->authorizedUser = User::find(auth()->id());
    }

    /**
     * @return User
     */
    public function getAuthorizedUser(): User
    {
        return $this->authorizedUser;
    }
}
