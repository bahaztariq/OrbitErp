<?php

namespace App\Ai\Tools\Clients;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteClientTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete a client record by their ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $client = $this->company->clients()->find($id);
        
        if (!$client) return "Error: Client not found.";

        $name = $client->name;
        $client->delete();
        return "Successfully deleted client: {$name}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the client to delete')->required(),
        ];
    }
}
