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

    public function test_register_user(){
        $data = [
            'name' => 'keeper test',
            'email' => 'keeperTest' . Str::random(10) . '@gmail.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ];

        $route = route('auth.register');
        $response = $this->post($route, $data);
        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'id'
            ],
            'token'
        ]);
        $response->assertStatus(201);

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
