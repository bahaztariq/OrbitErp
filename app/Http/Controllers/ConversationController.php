<?php

namespace App\Http\Controllers;

use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Http\Requests\Conversation\UpdateConversationRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Company;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Conversation::class);
        $conversations = $company->conversations;
        return view('conversations.index', compact('conversations', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Conversation::class);
        $users = $company->users;
        return view('conversations.create', compact('company', 'users'));
    }

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

        return redirect()->route('conversations.show', [$company->slug, $conversation->id])
            ->with('success', 'Conversation created successfully');
    }

    public function show(Company $company, Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        $conversation->load('messages', 'users');
        return view('conversations.show', compact('conversation', 'company'));
    }

    public function edit(Company $company, Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        $users = $company->users;
        return view('conversations.edit', compact('conversation', 'company', 'users'));
    }

    public function update(UpdateConversationRequest $request, Company $company, Conversation $conversation)
    {
        $this->authorize('update', $conversation);
        $conversation->update($request->validated());
        return redirect()->route('conversations.show', [$company->slug, $conversation->id])
            ->with('success', 'Conversation updated successfully');
    }

    public function destroy(Company $company, Conversation $conversation)
    {
        $this->authorize('delete', $conversation);
        $conversation->delete();
        return redirect()->route('conversations.index', $company->slug)
            ->with('success', 'Conversation deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $conversation = $company->conversations()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $conversation);
        $conversation->restore();
        return redirect()->route('conversations.show', [$company->slug, $conversation->id])
            ->with('success', 'Conversation restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $conversation = $company->conversations()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $conversation);
        $conversation->forceDelete();
        return redirect()->route('conversations.index', $company->slug)
            ->with('success', 'Conversation permanently deleted');
    }
}