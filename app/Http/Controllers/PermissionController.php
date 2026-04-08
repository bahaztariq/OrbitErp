<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Models\Company;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Company $company)
    {
        $permissions = $company->permissions;
        return view('permissions.index', compact('permissions', 'company'));
    }

    public function create(Company $company)
    {
        return view('permissions.create', compact('company'));
    }

    public function store(StorePermissionRequest $request, Company $company)
    {
        $permission = $company->permissions()->create($request->validated());
        return redirect()->route('permissions.index', $company->slug)
            ->with('success', 'Permission created successfully');
    }

    public function show(Company $company, Permission $permission)
    {
        return view('permissions.show', compact('permission', 'company'));
    }

    public function edit(Company $company, Permission $permission)
    {
        return view('permissions.edit', compact('permission', 'company'));
    }

    public function update(UpdatePermissionRequest $request, Company $company, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route('permissions.index', $company->slug)
            ->with('success', 'Permission updated successfully');
    }

    public function destroy(Company $company, Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index', $company->slug)
            ->with('success', 'Permission deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $permission = $company->permissions()->onlyTrashed()->findOrFail($id);
        $permission->restore();
        return redirect()->route('permissions.index', $company->slug)
            ->with('success', 'Permission restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $permission = $company->permissions()->onlyTrashed()->findOrFail($id);
        $permission->forceDelete();
        return redirect()->route('permissions.index', $company->slug)
            ->with('success', 'Permission permanently deleted');
    }
}
