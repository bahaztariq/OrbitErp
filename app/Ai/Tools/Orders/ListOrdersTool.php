<?php

namespace App\Ai\Tools\Orders;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListOrdersTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all customer and supplier orders.';
    }

    public function handle(Request $request): Stringable|string
    {
        $orders = $this->company->orders()->latest()->with('client')->get();

        if ($orders->isEmpty()) {
            return "No orders found.";
        }

        $output = "### Orders List\n\n| ID | Number | Client | Total | Status |\n|---|---|---|---|---|\n";
        foreach ($orders as $order) {
            $output .= "| {$order->id} | {$order->order_number} | " . ($order->client->name ?? 'N/A') . " | \${$order->total_amount} | {$order->status} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'status' => $schema->string()->description('Optional status filter (pending, completed, cancelled)')->nullable(),
        ];
    }
}
