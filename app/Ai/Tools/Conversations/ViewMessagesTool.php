<?php

namespace App\Ai\Tools\Conversations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ViewMessagesTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'View message history for a conversation by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('conversation_id');
        $conversation = $this->company->conversations()->find($id);

        if (!$conversation) return "Error: Conversation not found.";

        $messages = $conversation->messages()->oldest()->with('sender')->take(20)->get();

        if ($messages->isEmpty()) {
            return "No messages in this conversation yet.";
        }

        $output = "### Conversation: {$conversation->display_title}\n\n";
        foreach ($messages as $msg) {
            $sender = $msg->sender->name ?? 'System';
            $output .= "**{$sender}** ({$msg->created_at->diffForHumans()}): {$msg->message}\n\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'conversation_id' => $schema->integer()->description('ID of the conversation to view')->required(),
        ];
    }
}
