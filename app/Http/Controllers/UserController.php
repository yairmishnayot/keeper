<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserService $user_service;

    /**
     * initiating user service with user
     * @param $user
     */
    public function setUserService($user)
    {
        $this->user_service = new UserService($user);
    }

    /**
     * return the current logged user
     * @return User
     */
    public function getCurrentUser(): User
    {
        $this->user_service = new UserService(Auth::user());
        return $this->user_service->getCurrentUser();
    }
}
