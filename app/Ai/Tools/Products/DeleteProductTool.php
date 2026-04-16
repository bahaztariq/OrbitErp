<?php

namespace App\Ai\Tools\Products;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteProductTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete a product by its ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $product = $this->company->products()->find($id);

        if (!$product) return "Error: Product not found.";

        $name = $product->name;
        $product->delete();
        return "Successfully deleted product: {$name}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the product to delete')->required(),
        ];
    }
}
