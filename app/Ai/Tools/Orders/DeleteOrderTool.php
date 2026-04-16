<?php

namespace App\Ai\Tools\Orders;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteOrderTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete an order record by its ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $order = $this->company->orders()->find($id);

        if (!$order) return "Error: Order not found.";

        $num = $order->order_number;
        $order->delete();
        return "Successfully deleted order: {$num}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the order to delete')->required(),
        ];
    }
}
