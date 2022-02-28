<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getCurrentUser(): User
    {
        return $this->user;
    }
}
