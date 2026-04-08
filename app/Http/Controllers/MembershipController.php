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
        $memberships = $company->memberships;
        return view('memberships.index', compact('memberships', 'company'));
    }

    public function create(Company $company)
    {
        return view('memberships.create', compact('company'));
    }

    public function store(StoreMembershipRequest $request, Company $company)
    {
        $membership = $company->memberships()->create($request->validated());
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership created successfully');
    }

    public function show(Company $company, Membership $membership)
    {
        return view('memberships.show', compact('membership', 'company'));
    }

    public function edit(Company $company, Membership $membership)
    {
        return view('memberships.edit', compact('membership', 'company'));
    }

    public function update(UpdateMembershipRequest $request, Company $company, Membership $membership)
    {
        $membership->update($request->validated());
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership updated successfully');
    }

    public function destroy(Company $company, Membership $membership)
    {
        $membership->delete();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $membership->restore();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $membership = $company->memberships()->onlyTrashed()->findOrFail($id);
        $membership->forceDelete();
        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Membership permanently deleted');
    }
}
