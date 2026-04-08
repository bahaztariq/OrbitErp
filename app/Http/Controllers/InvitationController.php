<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitation\StoreInvitationRequest;
use App\Http\Requests\Invitation\UpdateInvitationRequest;
use App\Models\Invitation;
use App\Models\Company;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index(Company $company)
    {
        $invitations = $company->invitations;
        return view('invitations.index', compact('invitations', 'company'));
    }

    public function create(Company $company)
    {
        return view('invitations.create', compact('company'));
    }

    public function store(StoreInvitationRequest $request, Company $company)
    {
        $invitation = $company->invitations()->create($request->validated());
        return redirect()->route('invitations.index', $company->slug)
            ->with('success', 'Invitation sent successfully');
    }

    public function show(Company $company, Invitation $invitation)
    {
        return view('invitations.show', compact('invitation', 'company'));
    }

    public function edit(Company $company, Invitation $invitation)
    {
        return view('invitations.edit', compact('invitation', 'company'));
    }

    public function update(UpdateInvitationRequest $request, Company $company, Invitation $invitation)
    {
        $invitation->update($request->validated());
        return redirect()->route('invitations.index', $company->slug)
            ->with('success', 'Invitation updated successfully');
    }

    public function destroy(Company $company, Invitation $invitation)
    {
        $invitation->delete();
        return redirect()->route('invitations.index', $company->slug)
            ->with('success', 'Invitation deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $invitation = $company->invitations()->onlyTrashed()->findOrFail($id);
        $invitation->restore();
        return redirect()->route('invitations.index', $company->slug)
            ->with('success', 'Invitation restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $invitation = $company->invitations()->onlyTrashed()->findOrFail($id);
        $invitation->forceDelete();
        return redirect()->route('invitations.index', $company->slug)
            ->with('success', 'Invitation permanently deleted');
    }
}
