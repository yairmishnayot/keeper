<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

class KeeperTestCase extends TestCase
{
    use DatabaseTransactions;
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

    /**
     * Get a random user that have at least one note
     * @return object
     */
    protected function getRandomUserWithNotes(): object
    {
        return User::join('users_note', 'users_note.user_id','=','users.id')
            ->inRandomOrder()
            ->select('users.id', 'users.name', 'users.email')
            ->first();
    }

    /**
     * login into a user
     * @param $user
     * @return void
     */
    protected function loginUser($user){
        Auth::login($user);
    }

}
