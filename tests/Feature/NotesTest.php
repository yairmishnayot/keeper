<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\KeeperTestCase;

class NotesTest extends KeeperTestCase
{

    /**
     * test that user can create note
     * @return void
     * @throws \Exception
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
        $user = $this->getRandomUserWithNotes();
        $this->loginUser($user);
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
                    'pivot'
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

    /**
     * Test that user can update a note with edit permissions
     * @return void
     */
    public function test_edit_note(): void
    {
        //get user and one of his notes
        $user_with_note = $this->getRandomUserWithNotes();
        $note = $user_with_note->notes()->first();

        //log into the user
        $this->loginUser($user_with_note);
        $route = route('notes.update', $note->id);
        $note->name = Str::random();
        $response = $this->post($route, $note->toArray());

        $response->assertJson([
            'message' => 'note updated successfully'
        ]);

    }

    /**
     * test that user can delete its own note
     * @return void
     */
    public function test_delete_note(): void
    {
        //get user and one of his notes
        //get user and one of his notes
        $user_with_note = $this->getRandomUserWithNotes();
        $note = $user_with_note->notes()->first();

        //log into the user
        $this->loginUser($user_with_note);

        //delete the note
        $route = route('notes.delete', $note->id);
        $response = $this->delete($route);
        $response->assertJson([
           'message' =>  'Note deleted successfully'
        ]);

    }
}
