<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserService $user_service;

    public function __construct()
    {
        $this->setUserService(Auth::user());
    }

    public function setUserService($user){
        $this->user_service = new UserService($user);
    }

    public function getCurrentUser(){
        return $this->user_service->getCurrentUser();
    }
}
