<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitation\StoreInvitationRequest;
use App\Http\Requests\Invitation\UpdateInvitationRequest;
use App\Models\Invitation;
use App\Models\Company;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InvitationController extends Controller
{

    public function store(StoreInvitationRequest $request, Company $company)
    {
        $this->authorize('create', [Invitation::class, $company]);
        return $this->send($request, $company);
    }

    public function send(Request $request, Company $company)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $invitation = $company->invitations()->create([
            'email' => $request->email,
            'token' => Str::random(32),
            'status' => 'pending',
            'sent_at' => now(),
            'expired_at' => now()->addHours(24),
        ]);

        $url = URL::temporarySignedRoute(
            'invitations.accept',
            now()->addHours(24),
            ['token' => $invitation->token]
        );

        Mail::to($request->email)->send(new InvitationMail($url, $company));

        return redirect()->route('memberships.index', $company->slug)
            ->with('success', 'Invitation sent successfully!');
    }

    /**
     * Accept an invitation.
     */
    public function accept(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)
                        ->where('status', 'pending')
                        ->first();

        if (!$invitation) {
            return redirect()->route('companies.index')
                ->with('error', 'Invitation not found or already used.');
        }

        if ($invitation->isExpired()) {
            return redirect()->route('companies.index')
                ->with('error', 'This invitation has expired.');
        }

        // Guest: redirect to register with the email pre-filled
        if (auth()->guest()) {
            session(['pending_invite_token' => $token]);

            return redirect()->route('register', ['email' => $invitation->email])
                ->with('status', 'Please register to join the company.');
        }

        // Logged in: assign user to the company
        $user = auth()->user();

        $user->companies()->syncWithoutDetaching([$invitation->company_id]);

        $invitation->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        return redirect()->route('companies.show', $invitation->company->slug)
            ->with('success', 'You have joined ' . $invitation->company->name . '!');
    }

    
}