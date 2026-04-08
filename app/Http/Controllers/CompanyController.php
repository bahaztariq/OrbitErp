<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = auth()->user()->companies;
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = $request->user()->companies()->create($request->validated());

        return redirect()->route('companies.show', $company->slug)
            ->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()->route('companies.show', $company->slug)
            ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
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
        $company->forceDelete();

        return redirect()->route('companies.index')
            ->with('success', 'Company permanently deleted');
    }
}
