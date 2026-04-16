<?php

namespace App\Ai\Tools\Calendar;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteEventTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete a calendar event by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $event = $this->company->calenderEvents()->find($id);

        if (!$event) return "Error: Event not found.";

        $title = $event->title;
        $event->delete();
        return "Successfully deleted calendar event: {$title}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the event to delete')->required(),
        ];
    }
}
