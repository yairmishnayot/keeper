<?php

namespace App\Http\Requests;

use App\Services\NoteService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatenoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $note_id = $this->route()->parameters['id'];
        return NoteService::canUserEditNote(Auth::id(), $note_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|required',
            'content' => 'string|nullable',
            'background' => 'integer|nullable',
            'is_background_image' => 'boolean|nullable'
        ];
    }
}
