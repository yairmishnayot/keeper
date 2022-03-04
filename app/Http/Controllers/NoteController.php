<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Http\Requests\StorenoteRequest;
use App\Http\Requests\UpdatenoteRequest;
use App\Services\NoteService;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created note.
     *
     * @param  \App\Http\Requests\StorenoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorenoteRequest $request): \Illuminate\Http\JsonResponse
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
     * @param  \App\Models\note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(note $note)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenoteRequest  $request
     * @param  \App\Models\note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatenoteRequest $request, note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(note $note)
    {
        //
    }
}
