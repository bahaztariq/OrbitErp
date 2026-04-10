<?php

namespace App\Http\Controllers;

use App\Http\Requests\Membership\StoreMembershipRequest;
use App\Http\Requests\Membership\UpdateMembershipRequest;
use App\Models\Membership;
use App\Models\Company;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Company $company)
    {
        $this->authorize('viewAny', Membership::class);
        $memberships = $company->memberships;
        return view('memberships.index', compact('memberships', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Membership::class);
        $users = \App\Models\User::whereDoesntHave('companies', function($q) use ($company) {
            $q->where('companies.id', $company->id);
        })->get();
        return view('memberships.create', compact('company', 'users'));
    }

    public function store(StoreMembershipRequest $request, Company $company)
    {
        $this->authorize('create', Membership::class);
        $membership = $company->memberships()->create($request->validated());
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership created successfully');
    }

    public function show(Company $company, Membership $membership)
    {
        $this->authorize('view', $membership);
        return view('memberships.show', compact('membership', 'company'));
    }

    public function edit(Company $company, Membership $membership)
    {
        $this->authorize('view', $membership);
        $users = \App\Models\User::all();
        return view('memberships.edit', compact('membership', 'company', 'users'));
    }

    public function update(UpdateMembershipRequest $request, Company $company, Membership $membership)
    {
        $this->authorize('update', $membership);
        $membership->update($request->validated());
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership updated successfully');
    }

    public function destroy(Company $company, Membership $membership)
    {
        $this->authorize('delete', $membership);
        $membership->delete();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $membership);
        $membership->restore();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $membership);
        $membership->forceDelete();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership permanently deleted');
    }
}