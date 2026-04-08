<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Models\Company;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $permissions = $company->permissions;
        return response()->json([
            'message' => 'Permissions retrieved successfully',
            'data' => $permissions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request, Company $company)
    {
        $permission = $company->permissions()->create($request->validated());

        return response()->json([
            'message' => 'Permission created successfully',
            'data' => $permission
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Permission $permission)
    {
        return response()->json([
            'message' => 'Permission retrieved successfully',
            'data' => $permission
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Company $company, Permission $permission)
    {
        $permission->update($request->validated());

        return response()->json([
            'message' => 'Permission updated successfully',
            'data' => $permission
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $permission = $company->permissions()->onlyTrashed()->findOrFail($id);
        $permission->restore();

        return response()->json([
            'message' => 'Permission restored successfully',
            'data' => $permission
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $permission = $company->permissions()->onlyTrashed()->findOrFail($id);
        $permission->forceDelete();

        return response()->json([
            'message' => 'Permission permanently deleted'
        ], 200);
    }
}
