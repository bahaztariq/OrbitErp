<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use App\Models\Company;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Services\MessageService;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(StoreMessageRequest $request, Company $company)
    {
        $this->authorize('create', Message::class);
        
        $message = $this->messageService->sendMessage(
            auth()->user(), 
            $request->validated()
        );

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'data' => $message->load('sender')
            ]);
        }

        return redirect()->route('conversations.show', [$company->slug, $message->conversation_id])
            ->with('success', 'Message sent successfully');
    }


    public function update(UpdateMessageRequest $request, Company $company, Message $message)
    {
        $this->authorize('update', $message);
        
        if ($message->conversation->company_id !== $company->id) {
            abort(403);
        }

        $this->messageService->updateMessage(
            auth()->user(), 
            $message, 
            $request->message
        );

        return redirect()->back()->with('success', 'Message updated successfully');
    }

}