<?php

namespace App\Ai\Tools\Products;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListProductsTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all products and current stock levels.';
    }

    public function handle(Request $request): Stringable|string
    {
        $products = $this->company->products;

        if ($products->isEmpty()) {
            return "No products found.";
        }

        $output = "### Products List\n\n| ID | Name | SKU | Price | Stock |\n|---|---|---|---|---|\n";
        foreach ($products as $product) {
            $output .= "| {$product->id} | {$product->name} | {$product->sku} | {$product->price} | {$product->stock} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'category' => $schema->string()->description('Optional category to filter products')->nullable(),
        ];
    }
}
