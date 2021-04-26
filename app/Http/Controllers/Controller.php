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
     * @var User|null
     */
    private ?User $authorizedUser = null;

    /**
     * @return User
     */
    public function getAuthorizedUser(): User
    {
        if($this->authorizedUser === null)
        {
            $this->authorizedUser = User::find(auth()->id());
        }

        return $this->authorizedUser;
    }
}
