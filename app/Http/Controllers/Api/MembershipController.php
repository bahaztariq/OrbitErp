<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Membership\StoreMembershipRequest;
use App\Http\Requests\Membership\UpdateMembershipRequest;
use App\Models\Membership;
use App\Models\Company;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $memberships = $company->memberships;
        return response()->json([
            'message' => 'Memberships retrieved successfully',
            'data' => $memberships
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request, Company $company)
    {
        $membership = $company->memberships()->create($request->validated());

        return response()->json([
            'message' => 'Membership created successfully',
            'data' => $membership
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Membership $membership)
    {
        return response()->json([
            'message' => 'Membership retrieved successfully',
            'data' => $membership
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Company $company, Membership $membership)
    {
        $membership->update($request->validated());

        return response()->json([
            'message' => 'Membership updated successfully',
            'data' => $membership
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Membership $membership)
    {
        $membership->delete();

        return response()->json([
            'message' => 'Membership deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $membership->restore();

        return response()->json([
            'message' => 'Membership restored successfully',
            'data' => $membership
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $membership->forceDelete();

        return response()->json([
            'message' => 'Membership permanently deleted'
        ], 200);
    }
}
