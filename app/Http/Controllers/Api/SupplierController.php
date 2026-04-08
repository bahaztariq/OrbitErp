<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Models\Company;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $suppliers = $company->suppliers;
        return response()->json([
            'message' => 'Suppliers retrieved successfully',
            'data' => $suppliers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request, Company $company)
    {
        $supplier = $company->suppliers()->create($request->validated());

        return response()->json([
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Supplier $supplier)
    {
        return response()->json([
            'message' => 'Supplier retrieved successfully',
            'data' => $supplier
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Company $company, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return response()->json([
            'message' => 'Supplier updated successfully',
            'data' => $supplier
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'message' => 'Supplier deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $supplier = $company->suppliers()->onlyTrashed()->findOrFail($id);
        $supplier->restore();

        return response()->json([
            'message' => 'Supplier restored successfully',
            'data' => $supplier
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $supplier = $company->suppliers()->onlyTrashed()->findOrFail($id);
        $supplier->forceDelete();

        return response()->json([
            'message' => 'Supplier permanently deleted'
        ], 200);
    }
}
