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
        $this->authorize('viewAny', Role::class);
        $roles = $company->roles;
        return view('roles.index', compact('roles', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Role::class);
        $permissions = \App\Models\Permission::whereNotIn('name', [
            'view companies',
            'create companies',
            'view-any companies'
        ])->get()->groupBy(function($perm) {
            $parts = explode(' ', $perm->name, 2);
            return $parts[1] ?? 'other';
        });
        return view('roles.create', compact('company', 'permissions'));
    }

    public function store(StoreRoleRequest $request, Company $company)
    {
        $this->authorize('create', Role::class);
        $role = $company->roles()->create($request->validated());
        $role->permissions()->sync($request->permission_ids);
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role created successfully');
    }

    public function show(Company $company, Role $role)
    {
        $this->authorize('view', $role);
        return view('roles.show', compact('role', 'company'));
    }

    public function edit(Company $company, Role $role)
    {
        $this->authorize('update', $role);
        $permissions = \App\Models\Permission::whereNotIn('name', [
            'view companies',
            'create companies',
            'view-any companies'
        ])->get()->groupBy(function($perm) {
            $parts = explode(' ', $perm->name, 2);
            return $parts[1] ?? 'other';
        });
        return view('roles.edit', compact('role', 'company', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Company $company, Role $role)
    {
        $this->authorize('update', $role);
        $role->update($request->validated());
        $role->permissions()->sync($request->permission_ids);
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role updated successfully');
    }

    public function destroy(Company $company, Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $role);
        $role->restore();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $role = $company->roles()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $role);
        $role->forceDelete();
        return redirect()->route('roles.index', $company->slug)
            ->with('success', 'Role permanently deleted');
    }
}