<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Company;
use Illuminate\Http\Request;

class ConversationParticipantController extends Controller
{
    public function store(Request $request, Company $company, Conversation $conversation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Participant added successfully');
    }

    public function destroy(Company $company, Conversation $conversation, ConversationParticipant $participant)
    {
        $participant->delete();
        return redirect()->back()->with('success', 'Participant removed successfully');
    }
}
