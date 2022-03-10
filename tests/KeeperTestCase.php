<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KeeperTestCase extends TestCase
{

    /**
     * get random user from DB
     * @return mixed
     */
    protected function getRandomUser(){
        return User::inRandomOrder()->first();
    }

    /**
     * get a random user and then login into that user
     * @return mixed
     */
    protected function getRandomUserAndLogin(){
        $user = $this->getRandomUser();
        Auth::login($user);
        return $user;
    }

}
