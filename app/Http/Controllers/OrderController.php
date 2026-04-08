<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Company $company)
    {
        $orders = $company->orders;
        return view('orders.index', compact('orders', 'company'));
    }

    public function create(Company $company)
    {
        return view('orders.create', compact('company'));
    }

    public function store(StoreOrderRequest $request, Company $company)
    {
        $order = $company->orders()->create($request->validated());
        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order created successfully');
    }

    public function show(Company $company, Order $order)
    {
        return view('orders.show', compact('order', 'company'));
    }

    public function edit(Company $company, Order $order)
    {
        return view('orders.edit', compact('order', 'company'));
    }

    public function update(UpdateOrderRequest $request, Company $company, Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order updated successfully');
    }

    public function destroy(Company $company, Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index', $company->slug)
            ->with('success', 'Order deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $order = $company->orders()->onlyTrashed()->findOrFail($id);
        $order->restore();
        return redirect()->route('orders.show', [$company->slug, $order->id])
            ->with('success', 'Order restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $order = $company->orders()->onlyTrashed()->findOrFail($id);
        $order->forceDelete();
        return redirect()->route('orders.index', $company->slug)
            ->with('success', 'Order permanently deleted');
    }
}
