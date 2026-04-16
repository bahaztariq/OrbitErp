<?php

namespace App\Ai\Tools\Invitations;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CancelInvitationTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Cancel a pending invitation by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $invitation = $this->company->invitations()->find($id);
        
        if (!$invitation) return "Error: Invitation not found.";

        $email = $invitation->email;
        $invitation->delete();
        return "Successfully cancelled invitation for {$email}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the invitation to cancel')->required(),
        ];
    }
}
