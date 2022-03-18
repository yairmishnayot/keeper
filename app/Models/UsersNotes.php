<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\UsersNotes
 *
 * @property int $id
 * @property int $user_id
 * @property int $note_id
 * @property int $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereNoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersNotes whereUserId($value)
 * @mixin \Eloquent
 */
class UsersNotes extends Pivot
{
    public const ROLES = [
      "READ" => 1,
      "EDIT" => 2
    ];
}
