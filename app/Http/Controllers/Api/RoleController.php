<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Company;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $roles = $company->roles;
        return response()->json([
            'message' => 'Roles retrieved successfully',
            'data' => $roles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, Company $company)
    {
        $role = $company->roles()->create($request->validated());

        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Role $role)
    {
        return response()->json([
            'message' => 'Role retrieved successfully',
            'data' => $role
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Company $company, Role $role)
    {
        $role->update($request->validated());

        return response()->json([
            'message' => 'Role updated successfully',
            'data' => $role
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $role->restore();

        return response()->json([
            'message' => 'Role restored successfully',
            'data' => $role
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $role->forceDelete();

        return response()->json([
            'message' => 'Role permanently deleted'
        ], 200);
    }
}
