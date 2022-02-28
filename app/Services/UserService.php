<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private User $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function getCurrentUser(){
        return $this->user;
    }
}
