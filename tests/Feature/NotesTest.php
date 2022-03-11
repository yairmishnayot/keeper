<?php

namespace Tests\Feature;

use Tests\KeeperTestCase;

class NotesTest extends KeeperTestCase
{

    /**
     * test that user can create note
     * @return void
     */
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

    /**
     * test that user can get notes related to him
     * @return void
     */
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
     * test that user can get one of his notes by id
     * @return void
     */
    public function test_get_single_note(){

        //get user and one of his notes
        $user_with_note = $this->getRandomUserWithNotes();
        $note = $user_with_note->notes()->first();

        //log into the user
        $this->loginUser($user_with_note);

        $route = route('notes.show', $note);
        $response = $this->get($route);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'content',
                'background',
                'is_background_image',
                'pivot',
            ],
            'message'
        ]);
        $response->assertStatus(200);
    }
}
