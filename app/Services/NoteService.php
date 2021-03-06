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
                'role' => UsersNotes::ROLES["OWNER"]
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

    /**
     * Check if user can edit note
     * @param $user_id
     * @param $note_id
     * @return bool
     */
    public function canUserEditNote($user_id, $note_id): bool
    {
        $minimum_role_for_edit = UsersNotes::ROLES["EDIT"];
        $note = UsersNotes::where([
            'user_id' => $user_id,
            'note_id' => $note_id,
        ])
            ->where('role', '>=', $minimum_role_for_edit)
            ->first();
        return $note !== null;
    }

    /**
     * Check if user can delete note
     * @param $user_id
     * @param $note_id
     * @return bool
     */
    public function canUserDeleteNote($user_id, $note_id): bool
    {
        $note = UsersNotes::where([
            'user_id' => $user_id,
            'note_id' => $note_id,
            'role' => UsersNotes::ROLES["OWNER"]
        ])->first();
        return $note !== null;
    }

    /**
     * update note with updated note data
     * @param $note_id
     * @param $data
     * @return bool
     */
    public function updateNote($note_id, $data): bool
    {
        return Note::find($note_id)->update($data);
    }

    /**
     * delete a note
     * @param $note_id
     * @return bool|null
     */
    public function deleteNote($note_id): ?bool
    {
        return Note::find($note_id)->delete();
    }
}
