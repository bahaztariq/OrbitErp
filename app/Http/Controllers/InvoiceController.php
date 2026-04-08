<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Company;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Company $company)
    {
        $invoices = $company->invoices;
        return view('invoices.index', compact('invoices', 'company'));
    }

    public function create(Company $company)
    {
        return view('invoices.create', compact('company'));
    }

    public function store(StoreInvoiceRequest $request, Company $company)
    {
        $invoice = $company->invoices()->create($request->validated());
        return redirect()->route('invoices.show', [$company->slug, $invoice->id])
            ->with('success', 'Invoice created successfully');
    }

    public function show(Company $company, Invoice $invoice)
    {
        return view('invoices.show', compact('invoice', 'company'));
    }

    public function edit(Company $company, Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice', 'company'));
    }

    public function update(UpdateInvoiceRequest $request, Company $company, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return redirect()->route('invoices.show', [$company->slug, $invoice->id])
            ->with('success', 'Invoice updated successfully');
    }

    public function destroy(Company $company, Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index', $company->slug)
            ->with('success', 'Invoice deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $invoice = $company->invoices()->onlyTrashed()->findOrFail($id);
        $invoice->restore();
        return redirect()->route('invoices.show', [$company->slug, $invoice->id])
            ->with('success', 'Invoice restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $invoice = $company->invoices()->onlyTrashed()->findOrFail($id);
        $invoice->forceDelete();
        return redirect()->route('invoices.index', $company->slug)
            ->with('success', 'Invoice permanently deleted');
    }
}
