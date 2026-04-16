<?php

namespace App\Ai\Tools\Invitations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListInvitationsTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all pending team invitations.';
    }

    public function handle(Request $request): Stringable|string
    {
        $invitations = $this->company->invitations()->where('status', 'pending')->get();

        if ($invitations->isEmpty()) {
            return "No pending invitations found.";
        }

        $output = "### Pending Invitations\n\n| ID | Email | Role ID | Sent At |\n|---|---|---|---|\n";
        foreach ($invitations as $invite) {
            $output .= "| {$invite->id} | {$invite->email} | {$invite->role_id} | {$invite->sent_at} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'status' => $schema->string()->description('Filter by status (typically pending)')->nullable(),
        ];
    }
}
