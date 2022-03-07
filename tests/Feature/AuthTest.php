<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * test that we can get the current logged user
     *
     * @return void
     */
    public function test_get_current_user()
    {
        $this->getRandomUserAndLogin();
        $route = route('user.get_current');
        $response = $this->get($route);
        $response->assertJsonStructure([
            'id',
            'name',
            'email'
        ]);
        $response->assertStatus(200);
    }

    /**
     * test that we can register a user
     * @return void
     */
    public function test_register_user(){
        $data = [
            'name' => 'keeper test',
            'email' => 'keeperTest' . Str::random(10) . '@gmail.com',
            'password' =>  'secret123',
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

    /**
     * test that we can log in into existing user
     * @return void
     */
    public function test_login_user(){
        $data = [
            'name' => 'keeper test',
            'email' => 'keeperTest' . Str::random(10) . '@gmail.com',
            'password' => bcrypt('secret123'),
            'password_confirmation' => bcrypt('secret123')
        ];

        $user = User::create($data);
        $route = route('auth.login');
        $login_data = [
          'email' => $user->email,
          'password' => 'secret123'
        ];

        $response = $this->post($route, $login_data);
        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'id'
            ],
            'token'
        ]);
        $response->assertStatus(200);

    }

    /**
     * test that we can logout a user
     * @return void
     */
    public function test_logout_user(){
        $this->getRandomUserAndLogin();
        $route = route('user.logout');
        $response = $this->get($route);
        $response->assertJson([
           'message' => 'Logged out successfully'
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
     * @return mixed
     */
    private function getRandomUserAndLogin(){
        $user = $this->getRandomUser();
        Auth::login($user);
        return $user;
    }
}
