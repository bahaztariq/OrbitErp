<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Order::class);
        $orders = $company->orders;
        return view('orders.index', compact('orders', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Order::class);
        $clients = $company->clients;
        $suppliers = $company->suppliers;
        $products = $company->products;
        return view('orders.create', compact('company', 'clients', 'suppliers', 'products'));
    }

    public function store(StoreOrderRequest $request, Company $company)
    {
        $this->authorize('create', Order::class);
        
        $order = DB::transaction(function () use ($request, $company) {
            $data = $request->validated();
            $data['total_amount'] = collect($request->items)->sum(fn($item) => $item['quantity'] * $item['price']);
            $order = $company->orders()->create($data);
            
            foreach ($request->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            
            return $order;
        });

        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order created successfully');
    }

    public function show(Company $company, Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order', 'company'));
    }

    public function edit(Company $company, Order $order)
    {
        $this->authorize('view', $order);
        $clients = $company->clients;
        $suppliers = $company->suppliers;
        $products = $company->products;
        return view('orders.edit', compact('order', 'company', 'clients', 'suppliers', 'products'));
    }

    public function update(UpdateOrderRequest $request, Company $company, Order $order)
    {
        $this->authorize('update', $order);
        
        DB::transaction(function () use ($request, $order) {
            $data = $request->validated();
            if ($request->has('items')) {
                $data['total_amount'] = collect($request->items)->sum(fn($item) => $item['quantity'] * $item['price']);
            }
            $order->update($data);
            
            if ($request->has('items')) {
                $order->orderItems()->delete();
                foreach ($request->items as $item) {
                    $order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
        });

        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order updated successfully');
    }

    public function destroy(Company $company, Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.index', $company->slug)
            ->with('success', 'Order deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $order = $company->orders()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $order);
        $order->restore();
        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $order = $company->orders()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $order);
        $order->forceDelete();
        return redirect()->route('orders.index', $company->slug)
            ->with('success', 'Order permanently deleted');
    }
}