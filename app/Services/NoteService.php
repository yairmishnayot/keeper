<?php

namespace App\Services;

use App\Models\Note;
use App\Models\UsersNotes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NoteService
{

    private int $user_id;

    /**
     * @param $user_id
     */
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get all current user notes
     * @return Collection
     */
    public function getCurrentUserNotes(): Collection
    {
        return Note::join('users_note', 'note_id', '=', 'notes.id')
            ->where('users_note.user_id', '=', $this->user_id)
            ->select('notes.id','title', 'content', 'background', 'is_background_image', 'users_note.role')
            ->get();
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
        $note = Note::where('notes.id', $note_id)
            ->join('users_note', 'note_id', '=', 'notes.id')
            ->where('users_note.user_id', Auth::id())
            ->select('notes.id', 'title', 'content', 'background', 'is_background_image', 'users_note.role')
            ->first();
        if(!$note){
            throw new \Exception("We did not find the resource you were looking for", '404');
        }
        return $note;
    }
}
