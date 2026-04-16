<?php

namespace App\Ai\Tools\Calendar;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListEventsTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all calendar events.';
    }

    public function handle(Request $request): Stringable|string
    {
        $events = $this->company->calenderEvents()->latest()->get();

        if ($events->isEmpty()) {
            return "No calendar events found.";
        }

        $output = "### Calendar Events\n\n| ID | Title | Date |\n|---|---|---|\n";
        foreach ($events as $event) {
            $output .= "| {$event->id} | {$event->title} | {$event->event_date} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'date' => $schema->string()->description('Optional date filter (YYYY-MM-DD)')->nullable(),
        ];
    }
}
