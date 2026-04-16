<?php

namespace App\Ai\Tools\Orders;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class UpdateOrderTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Update an order record by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $order = $this->company->orders()->find($id);

        if (!$order) return "Error: Order not found.";

        $order->update($request->all());
        return "Successfully updated order: {$order->order_number}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the order to update')->required(),
            'total_amount' => $schema->number()->description('Updated total amount')->nullable(),
            'status' => $schema->string()->description('Updated status')->nullable(),
        ];
    }
}
