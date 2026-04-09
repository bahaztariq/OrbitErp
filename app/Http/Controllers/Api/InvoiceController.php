<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Company;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', Invoice::class);
        $invoices = $company->invoices;
        return response()->json([
            'message' => 'Invoices retrieved successfully',
            'data' => $invoices
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request, Company $company)
    {
        $this->authorize('create', Invoice::class);
        $invoice = $company->invoices()->create($request->validated());

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        return response()->json([
            'message' => 'Invoice retrieved successfully',
            'data' => $invoice
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Company $company, Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        $invoice->update($request->validated());

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Invoice $invoice)
    {
        $this->authorize('delete', $invoice);
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $invoice = $company->invoices()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $invoice);
        $invoice->restore();

        return response()->json([
            'message' => 'Invoice restored successfully',
            'data' => $invoice
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $invoice = $company->invoices()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $invoice);
        $invoice->forceDelete();

        return response()->json([
            'message' => 'Invoice permanently deleted'
        ], 200);
    }
}
