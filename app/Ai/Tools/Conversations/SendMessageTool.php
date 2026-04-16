<?php

namespace App\Ai\Tools\Conversations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class SendMessageTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Send a message to a conversation. Requires conversation_id and content.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('conversation_id');
        $content = $request->get('content');

        if (!$content) return "Error: Message content is required.";

        $conversation = $this->company->conversations()->find($id);
        if (!$conversation) return "Error: Conversation not found.";

        $conversation->messages()->create([
            'message' => $content,
            'sender_id' => auth()->id() ?? 1,
        ]);

        return "Successfully sent message.";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'conversation_id' => $schema->integer()->description('ID of the conversation to message')->required(),
            'content' => $schema->string()->description('The message content to send')->required(),
        ];
    }
}
