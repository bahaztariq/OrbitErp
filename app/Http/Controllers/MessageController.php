<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use App\Models\Company;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Message::class);
        $messages = Message::whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();

        return view('messages.index', compact('messages', 'company'));
    }

    public function store(StoreMessageRequest $request, Company $company)
    {
        $this->authorize('create', Message::class);
        $conversation = $company->conversations()->findOrFail($request->conversation_id);
        
        $message = $conversation->messages()->create($request->validated() + [
            'sender_id' => auth()->id()
        ]);

        return redirect()->route('conversations.show', [$company->slug, $conversation->id])
            ->with('success', 'Message sent successfully');
    }

    public function show(Company $company, Message $message)
    {
        $this->authorize('view', $message);
        if ($message->conversation->company_id !== $company->id) {
            abort(403);
        }

        return view('messages.show', compact('message', 'company'));
    }

    public function update(UpdateMessageRequest $request, Company $company, Message $message)
    {
        $this->authorize('update', $message);
        if ($message->conversation->company_id !== $company->id) {
            abort(403);
        }

        $message->update($request->validated());
        return redirect()->back()->with('success', 'Message updated successfully');
    }

    public function destroy(Company $company, Message $message)
    {
        $this->authorize('delete', $message);
        if ($message->conversation->company_id !== $company->id) {
            abort(403);
        }

        $message->delete();
        return redirect()->back()->with('success', 'Message deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $message = Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->findOrFail($id);
        
        $message->restore();
        return redirect()->back()->with('success', 'Message restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $message = Message::onlyTrashed()->whereHas('conversation', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->findOrFail($id);
        
        $message->forceDelete();
        return redirect()->back()->with('success', 'Message permanently deleted');
    }
}