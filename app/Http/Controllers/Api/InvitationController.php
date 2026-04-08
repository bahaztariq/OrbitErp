<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Invitation\StoreInvitationRequest;
use App\Http\Requests\Invitation\UpdateInvitationRequest;
use App\Models\Invitation;
use App\Models\Company;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $invitations = $company->invitations;
        return response()->json([
            'message' => 'Invitations retrieved successfully',
            'data' => $invitations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationRequest $request, Company $company)
    {
        $invitation = $company->invitations()->create($request->validated());

        return response()->json([
            'message' => 'Invitation created successfully',
            'data' => $invitation
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Invitation $invitation)
    {
        return response()->json([
            'message' => 'Invitation retrieved successfully',
            'data' => $invitation
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvitationRequest $request, Company $company, Invitation $invitation)
    {
        $invitation->update($request->validated());

        return response()->json([
            'message' => 'Invitation updated successfully',
            'data' => $invitation
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Invitation $invitation)
    {
        $invitation->delete();

        return response()->json([
            'message' => 'Invitation deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $invitation = $company->invitations()->onlyTrashed()->findOrFail($id);
        $invitation->restore();

        return response()->json([
            'message' => 'Invitation restored successfully',
            'data' => $invitation
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $invitation = $company->invitations()->onlyTrashed()->findOrFail($id);
        $invitation->forceDelete();

        return response()->json([
            'message' => 'Invitation permanently deleted'
        ], 200);
    }
}
