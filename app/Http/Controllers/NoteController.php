<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Http\Requests\StorenoteRequest;
use App\Http\Requests\UpdatenoteRequest;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * @var NoteService
     */
    private NoteService $note_service;

    public function __construct(NoteService $note_service)
    {
        $this->note_service = $note_service;
    }

    /**
     * * Get all current user notes
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $notes = $this->note_service->getCurrentUserNotes();
            $response = [
                'data' => $notes,
                'message' => "User's notes were retrieved successfully"
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);

        }
    }

    /**
     * Store a newly created note.
     *
     * @param StorenoteRequest $request
     * @return JsonResponse
     */
    public function store(StorenoteRequest $request): JsonResponse
    {
        try {
            $data = $request->only('title', 'content', 'background', 'is_background_image');
            $note = NoteService::createNote($data);
            return response()->json($note, 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * return a single note
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $note = $this->note_service->getNote($id);
            if ($note) {
                $response = [
                    "data" => $note,
                    "message" => 'Fetched note successfully',
                ];
                $status = 200;
            } else {
                $response = [
                    "data" => null,
                    "message" => 'We could not find the note you were looking for'
                ];
                $status = 404;
            }

            return response()->json($response, $status);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }


    /**
     * Update the specified resource in storage.
     * @param UpdatenoteRequest $request
     * @param $note_id
     * @return JsonResponse
     */
    public function update(UpdatenoteRequest $request, $note_id): JsonResponse
    {
        try {
            if(!$this->note_service->canUserEditNote(Auth::id(), $note_id)){
                $response = [
                    "message" => "You are not authorized to edit this note"
                ];
                return response()->json($response, '403');
            }
            $data = $request->only('title', 'content', 'background', 'is_background_image');
            if($this->note_service->updateNote($note_id, $data)){
                $response = [
                    "message" => "note updated successfully"
                ];
                return response()->json($response);
            }
            else{
                throw new \Exception("Some error occurred during the update process. We could not update the note");
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param note $note
     * @return Response
     */
    public function destroy(note $note)
    {
        //
    }
}
