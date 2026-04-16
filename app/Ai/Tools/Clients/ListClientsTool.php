<?php

namespace App\Ai\Tools\Clients;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListClientsTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all clients for the current company.';
    }

    public function handle(Request $request): Stringable|string
    {
        $clients = $this->company->clients;

        if ($clients->isEmpty()) {
            return "No clients found.";
        }

        $output = "### Clients List\n\n| ID | Name | Email | Status |\n|---|---|---|---|\n";
        foreach ($clients as $client) {
            $output .= "| {$client->id} | {$client->name} | {$client->email} | {$client->status} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->description('Optional search term to filter clients by name or email')->nullable(),
        ];
    }
}
