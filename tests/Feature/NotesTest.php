<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\KeeperTestCase;

class NotesTest extends KeeperTestCase
{
    use DatabaseTransactions;

    public function test_create_note(){
        $this->getRandomUserAndLogin();

        //prepare the data
        $data = [
            "title" => "this is some test title",
            "content" => "this is some test content"
        ];

        $route = route('notes.create');
        $response = $this->post($route, $data);

        $response->assertJsonStructure([
            'id', 'title', 'content'
        ]);

        $response->assertStatus(201);
    }
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
}
