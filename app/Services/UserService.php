<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private User $user;

    /**
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * get current logged user
     * @return User
     */
    public function getCurrentUser(): User
    {
        return $this->user;
    }
}
