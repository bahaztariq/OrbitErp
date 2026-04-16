<?php

namespace App\Ai\Tools\Products;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class UpdateProductTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Update product details by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $product = $this->company->products()->find($id);

        if (!$product) return "Error: Product not found.";

        $product->update($request->all());
        return "Successfully updated product: {$product->name}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the product to update')->required(),
            'name' => $schema->string()->description('Updated name')->nullable(),
            'price' => $schema->number()->description('Updated price')->nullable(),
            'stock' => $schema->integer()->description('Updated stock level')->nullable(),
        ];
    }
}
