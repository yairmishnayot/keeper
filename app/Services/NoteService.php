<?php

namespace App\Services;

use App\Models\Note;
use App\Models\UsersNotes;
use Illuminate\Support\Facades\Auth;

class NoteService
{
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
}
