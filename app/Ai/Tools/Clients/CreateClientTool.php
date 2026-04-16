<?php

namespace App\Ai\Tools\Clients;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateClientTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new client record. Pass client data like name, email, phone, and city.';
    }

    public function handle(Request $request): Stringable|string
    {
        $client = $this->company->clients()->create($request->all());
        return "Successfully created client: {$client->name} (ID: {$client->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->description('Full name of the client')->required(),
            'email' => $schema->string()->description('Email address of the client')->nullable(),
            'phone' => $schema->string()->description('Phone number')->nullable(),
            'city' => $schema->string()->description('City of residence')->nullable(),
        ];
    }
}
