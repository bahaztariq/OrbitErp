<?php

namespace App\Ai\Tools\Calendar;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateEventTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new calendar event.';
    }

    public function handle(Request $request): Stringable|string
    {
        $event = $this->company->calenderEvents()->create($request->all());
        return "Successfully created calendar event: {$event->title} (ID: {$event->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Event title')->required(),
            'event_date' => $schema->string()->description('Event date (YYYY-MM-DD)')->required(),
        ];
    }
}
