<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Company::class);
        $companies = auth()->user()->companies;
        return response()->json([
            'message' => 'Companies retrieved successfully',
            'data' => $companies
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Company::class);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $company = $request->user()->companies()->create($request->validated());

        return response()->json([
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);
        return response()->json([
            'message' => 'Company retrieved successfully',
            'data' => $company
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $this->authorize('view', $company);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);
        $company->update($request->validated());

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => $company
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);
        $company->delete();
        return response()->json([
            'message' => 'Company deleted successfully',
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $company = auth()->user()->companies()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $company);
        $company->restore();

        return response()->json([
            'message' => 'Company restored successfully',
            'data' => $company
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $company = auth()->user()->companies()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $company);
        $company->forceDelete();

        return response()->json([
            'message' => 'Company permanently deleted'
        ], 200);
    }
}