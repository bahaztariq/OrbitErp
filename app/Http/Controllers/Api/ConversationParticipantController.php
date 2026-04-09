<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\ConversationParticipant\StoreConversationParticipantRequest;
use App\Http\Requests\ConversationParticipant\UpdateConversationParticipantRequest;
use App\Models\ConversationParticipant;

class ConversationParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Participants retrieved successfully',
            'data' => ConversationParticipant::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConversationParticipantRequest $request)
    {
        $participant = ConversationParticipant::create($request->validated());

        return response()->json([
            'message' => 'Participant added successfully',
            'data' => $participant
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConversationParticipant $conversationParticipant)
    {
        return response()->json([
            'message' => 'Participant retrieved successfully',
            'data' => $conversationParticipant
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationParticipantRequest $request, ConversationParticipant $conversationParticipant)
    {
        $conversationParticipant->update($request->validated());

        return response()->json([
            'message' => 'Participant updated successfully',
            'data' => $conversationParticipant
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConversationParticipant $conversationParticipant)
    {
        $conversationParticipant->delete();

        return response()->json([
            'message' => 'Participant removed successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $participant = ConversationParticipant::withTrashed()->findOrFail($id);
        $participant->restore();

        return response()->json([
            'message' => 'Participant restored successfully',
            'data' => $participant
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $participant = ConversationParticipant::withTrashed()->findOrFail($id);
        $participant->forceDelete();

        return response()->json([
            'message' => 'Participant permanently removed'
        ], 200);
    }
}