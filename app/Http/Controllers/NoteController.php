<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Http\Requests\StorenoteRequest;
use App\Http\Requests\UpdatenoteRequest;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
