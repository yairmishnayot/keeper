<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class NotesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_logged_user_notes(){
        $this->getRandomUserAndLogin();
        $route = route('notes.index');
        $response = $this->get($route);

        $response->assertJsonStructure([
            'data' => [
                '*'=>[
                    'id',
                    'title',
                    'content',
                    'background',
                    'is_background_image',
                    'role'
                ]
            ],
            'message'
        ]);
        $response->assertStatus(200);
    }


    /**
     * get random user from DB
     * @return mixed
     */
    private function getRandomUser(){
        return User::inRandomOrder()->first();
    }

    /**
     * get a random user and then login into that user
     * @return User|null
     */
    private function getRandomUserAndLogin(): User | null
    {
        $user = $this->getRandomUser();
        Auth::login($user);
        return $user;
    }
}
