<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Client;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Order;
use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Company::class);
        $companies = auth()->user()->companies;
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Company::class);
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('create', Company::class);
        $company = $request->user()->companies()->create($request->validated());

        return redirect()->route('companies.show', $company->slug)
            ->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, StatsService $statsService)
    {
        $this->authorize('view', $company);
        
        $stats = $statsService->getCompanyMetrics($company);
        $monthlyRevenue = $statsService->getMonthlyRevenue($company);
        $clientGrowth = $statsService->getClientGrowth($company);
        $orderStatusDist = $statsService->getOrderStatusDist($company);
        $invoiceStatusDist = $statsService->getInvoiceStatusDist($company);

        $company->loadCount('users');
        
        return view('companies.show', compact(
            'company', 
            'stats', 
            'monthlyRevenue',
            'clientGrowth',
            'orderStatusDist',
            'invoiceStatusDist'
        ));
    }

    /**
     * Display company information.
     */
    public function info(Company $company)
    {
        $this->authorize('view', $company);
        $company->loadCount('users');
        return view('companies.info', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $this->authorize('view', $company);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);
        $company->update($request->validated());

        return redirect()->route('companies.show', $company->slug)
            ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $company = auth()->user()->companies()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $company);
        $company->restore();

        return redirect()->route('companies.show', $company->slug)
            ->with('success', 'Company restored successfully');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $company = auth()->user()->companies()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $company);
        $company->forceDelete();

        return redirect()->route('companies.index')
            ->with('success', 'Company permanently deleted');
    }
}