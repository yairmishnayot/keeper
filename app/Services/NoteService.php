<?php

namespace App\Services;

use App\Models\Note;
use App\Models\UsersNotes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NoteService
{

    /**
     * Get all current user notes
     * @return Collection
     */
    public function getCurrentUserNotes(): Collection
    {
        return Auth::user()->notes;
    }

    /**
     * create new note in db
     * @param $note_date
     * @return mixed
     */
    public static function createNote($note_date){
        $note = Note::create($note_date);
        if($note){
            $user_id = Auth::id();
            UsersNotes::create([
                'user_id' => $user_id,
                'note_id' => $note->id,
                'role' => 2
            ]);
        }
        return $note;
    }


    /**
     * get user's note by it's id
     * @param $note_id
     * @return Note|null
     * @throws \Exception
     */
    public function getNote($note_id): Note|null
    {
        return Auth::user()->notes->find($note_id);
    }
}
