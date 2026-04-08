<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Company $company)
    {
        $products = $company->products;
        return view('products.index', compact('products', 'company'));
    }

    public function show(Company $company, Product $product)
    {
        return view('products.show', compact('product', 'company'));
    }

    public function create(Company $company)
    {
        return view('products.create', compact('company'));
    }

    public function store(StoreProductRequest $request, Company $company)
    {
        $product = $company->products()->create($request->validated());

        return redirect()->route('products.show', [$company->slug, $product->id])
            ->with('success', 'Product created successfully');
    }

    public function edit(Company $company, Product $product)
    {
        return view('products.edit', compact('product', 'company'));
    }

    public function update(UpdateProductRequest $request, Company $company, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.show', [$company->slug, $product->id])
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Company $company, Product $product)
    {
        $product->delete();
        return redirect()->route('products.index', $company->slug)
            ->with('success', 'Product deleted successfully');
    }
}
