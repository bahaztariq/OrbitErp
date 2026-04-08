<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use App\Models\Company;
use App\Models\Conversation;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $messages = Message::whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();

        return response()->json([
            'message' => 'Messages retrieved successfully',
            'data' => $messages
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Company $company)
    {
        // Ensure the conversation belongs to the company
        $conversation = $company->conversations()->findOrFail($request->conversation_id);
        
        $message = $conversation->messages()->create($request->validated() + [
            'sender_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Message $message)
    {
        if ($message->conversation->company_id !== $company->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Message retrieved successfully',
            'data' => $message
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Company $company, Message $message)
    {
        if ($message->conversation->company_id !== $company->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->update($request->validated());

        return response()->json([
            'message' => 'Message updated successfully',
            'data' => $message
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Message $message)
    {
        if ($message->conversation->company_id !== $company->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $message = Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->findOrFail($id);
        
        $message->restore();

        return response()->json([
            'message' => 'Message restored successfully',
            'data' => $message
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $message = Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->findOrFail($id);
        
        $message->forceDelete();

        return response()->json([
            'message' => 'Message permanently deleted'
        ], 200);
    }
}
