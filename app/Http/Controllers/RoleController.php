<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Company $company)
    {
        $roles = $company->roles;
        return view('roles.index', compact('roles', 'company'));
    }

    public function create(Company $company)
    {
        return view('roles.create', compact('company'));
    }

    public function store(StoreRoleRequest $request, Company $company)
    {
        $role = $company->roles()->create($request->validated());
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role created successfully');
    }

    public function show(Company $company, Role $role)
    {
        return view('roles.show', compact('role', 'company'));
    }

    public function edit(Company $company, Role $role)
    {
        return view('roles.edit', compact('role', 'company'));
    }

    public function update(UpdateRoleRequest $request, Company $company, Role $role)
    {
        $role->update($request->validated());
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role updated successfully');
    }

    public function destroy(Company $company, Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $role->restore();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $role->forceDelete();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role permanently deleted');
    }
}
