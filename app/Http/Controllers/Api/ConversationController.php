<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Http\Requests\Conversation\UpdateConversationRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Company;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', Conversation::class);
        return response()->json([
            'message' => 'Conversations retrieved successfully',
            'data' => $company->conversations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConversationRequest $request, Company $company)
    {
        $this->authorize('create', Conversation::class);
        $conversation = $company->conversations()->create($request->validated());

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
        ]);

        if ($request->has('user_ids')) {
            foreach ($request->user_ids as $user_id) {
                ConversationParticipant::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user_id,
                ]);
            }
        }

        return response()->json([
            'message' => 'Conversation created successfully',
            'data' => $conversation
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        return response()->json([
            'message' => 'Conversation retrieved successfully',
            'data' => $conversation->load('messages', 'users')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationRequest $request, Company $company, Conversation $conversation)
    {
        $this->authorize('update', $conversation);
        $conversation->update($request->validated());

        return response()->json([
            'message' => 'Conversation updated successfully',
            'data' => $conversation
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Conversation $conversation)
    {
        $this->authorize('delete', $conversation);
        $conversation->delete();

        return response()->json([
            'message' => 'Conversation deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $conversation = $company->conversations()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $conversation);
        $conversation->restore();

        return response()->json([
            'message' => 'Conversation restored successfully',
            'data' => $conversation
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $conversation = $company->conversations()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $conversation);
        $conversation->forceDelete();

        return response()->json([
            'message' => 'Conversation permanently deleted'
        ], 200);
    }
}