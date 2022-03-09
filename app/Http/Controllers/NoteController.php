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

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->note_service = new NoteService(Auth::id());
            return $next($request);
        });
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
        try{
            $data = $request->only('title', 'content', 'background', 'is_background_image');
            $note = NoteService::createNote($data);
            return response()->json($note);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param note $note
     * @return Response
     */
    public function show(note $note)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdatenoteRequest $request
     * @param note $note
     * @return Response
     */
    public function update(UpdatenoteRequest $request, note $note)
    {
        //
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
