<?php

namespace App\Ai\Tools\Conversations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListConversationsTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all internal team conversations.';
    }

    public function handle(Request $request): Stringable|string
    {
        $conversations = $this->company->conversations()->latest()->get();

        if ($conversations->isEmpty()) {
            return "No conversations found.";
        }

        $output = "### Conversations\n\n| ID | Title | Description |\n|---|---|---|\n";
        foreach ($conversations as $conv) {
            $output .= "| {$conv->id} | {$conv->display_title} | {$conv->description} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'limit' => $schema->integer()->description('Max number of conversations to return')->nullable(),
        ];
    }
}
