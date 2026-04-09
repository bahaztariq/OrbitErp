<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Supplier::class);
        $suppliers = $company->suppliers;
        return view('suppliers.index', compact('suppliers', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Supplier::class);
        return view('suppliers.create', compact('company'));
    }

    public function store(StoreSupplierRequest $request, Company $company)
    {
        $this->authorize('create', Supplier::class);
        $supplier = $company->suppliers()->create($request->validated());
        return redirect()->route('suppliers.index', $company->slug)
            ->with('success', 'Supplier created successfully');
    }

    public function show(Company $company, Supplier $supplier)
    {
        $this->authorize('view', $supplier);
        return view('suppliers.show', compact('supplier', 'company'));
    }

    public function edit(Company $company, Supplier $supplier)
    {
        $this->authorize('view', $supplier);
        return view('suppliers.edit', compact('supplier', 'company'));
    }

    public function update(UpdateSupplierRequest $request, Company $company, Supplier $supplier)
    {
        $this->authorize('update', $supplier);
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index', $company->slug)
            ->with('success', 'Supplier updated successfully');
    }

    public function destroy(Company $company, Supplier $supplier)
    {
        $this->authorize('delete', $supplier);
        $supplier->delete();
        return redirect()->route('suppliers.index', $company->slug)
            ->with('success', 'Supplier deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $supplier = $company->suppliers()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $supplier);
        $supplier->restore();
        return redirect()->route('suppliers.index', $company->slug)
            ->with('success', 'Supplier restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $supplier = $company->suppliers()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $supplier);
        $supplier->forceDelete();
        return redirect()->route('suppliers.index', $company->slug)
            ->with('success', 'Supplier permanently deleted');
    }
}