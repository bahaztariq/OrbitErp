<?php

namespace App\Ai\Tools\Products;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateProductTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new product with details like name, price, stock, and SKU.';
    }

    public function handle(Request $request): Stringable|string
    {
        $product = $this->company->products()->create($request->all());
        return "Successfully created product: {$product->name} (ID: {$product->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->description('Product name')->required(),
            'price' => $schema->number()->description('Product price')->required(),
            'stock' => $schema->integer()->description('Initial stock level')->required(),
            'sku' => $schema->string()->description('Unique SKU for the product')->nullable(),
        ];
    }
}
