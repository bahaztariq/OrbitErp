<?php

namespace App\Ai\Tools\Orders;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateOrderTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new order record.';
    }

    public function handle(Request $request): Stringable|string
    {
        $order = $this->company->orders()->create($request->all());
        return "Successfully created order: {$order->order_number} (ID: {$order->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'order_number' => $schema->string()->description('Unique order number')->required(),
            'client_id' => $schema->integer()->description('ID of the client/supplier')->required(),
            'total_amount' => $schema->number()->description('Total order amount')->required(),
            'status' => $schema->string()->description('Status (pending, completed, cancelled)')->nullable(),
        ];
    }
}
