<?php

namespace App\Ai\Tools\Invitations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;
use Illuminate\Support\Str;

class SendInvitationTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Send a new team invitation to an email address.';
    }

    public function handle(Request $request): Stringable|string
    {
        $email = $request->get('email');
        if (!$email) return "Error: Email is required.";

        $invitation = $this->company->invitations()->create([
            'email' => $email,
            'role_id' => $request->get('role_id', 2),
            'token' => Str::random(40),
            'status' => 'pending',
            'sent_at' => now(),
            'expired_at' => now()->addDays(7),
        ]);

        return "Successfully sent invitation to {$email} (Role ID: {$invitation->role_id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'email' => $schema->string()->description('Email address to invite')->required(),
            'role_id' => $schema->integer()->description('Optional role ID')->nullable(),
        ];
    }
}
