<?php

namespace App\Ai\Tools\Clients;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class UpdateClientTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Update an existing client record. Requires client ID and the data to update.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $client = $this->company->clients()->find($id);
        
        if (!$client) return "Error: Client not found.";

        $client->update($request->all());
        return "Successfully updated client: {$client->name}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the client to update')->required(),
            'name' => $schema->string()->description('Updated name')->nullable(),
            'email' => $schema->string()->description('Updated email')->nullable(),
            'phone' => $schema->string()->description('Updated phone')->nullable(),
            'city' => $schema->string()->description('Updated city')->nullable(),
        ];
    }
}
