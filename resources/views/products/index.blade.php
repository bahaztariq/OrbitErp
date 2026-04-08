@extends('layouts.app')

@section('title', 'Products - ' . $company->name)

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Products for {{ $company->name }}
        </h3>
        <a href="{{ route('products.create', $company->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Add Product
        </a>
    </div>
    <ul class="divide-y divide-gray-200">
        @forelse($products as $product)
            <li>
                <a href="{{ route('products.show', [$company->slug, $product->id]) }}" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-blue-600 truncate">
                                {{ $product->name }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $product->sku ?? 'No SKU' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    Price: ${{ number_format($product->price, 2) }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <p>
                                    Stock: {{ $product->stock ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="px-4 py-8 text-center text-gray-500">
                No products found for this company.
            </li>
        @endforelse
    </ul>
</div>
@endsection
