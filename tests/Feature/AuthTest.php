<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_current_user()
    {
        $this->getRandomUserAndLogin();
        $route = route('auth.get_user');
        $response = $this->get($route);
        $response->assertJsonStructure([
            'id',
            'name',
            'email'
        ]);
        $response->assertStatus(200);
    }

    private function getRandomUser(){
        return User::inRandomOrder()->first();
    }

    private function getRandomUserAndLogin(){
        $user = $this->getRandomUser();
        Auth::login($user);
        return $user;
    }
}
