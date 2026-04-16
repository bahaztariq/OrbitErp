<?php

namespace App\Ai\Tools\Tasks;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ListTasksTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'List all tasks for the current company.';
    }

    public function handle(Request $request): Stringable|string
    {
        $tasks = $this->company->tasks()->latest()->get();

        if ($tasks->isEmpty()) {
            return "No tasks found.";
        }

        $output = "### Tasks List\n\n| ID | Title | Priority | Status | Due Date |\n|---|---|---|---|---|\n";
        foreach ($tasks as $task) {
            $output .= "| {$task->id} | {$task->title} | {$task->priority} | {$task->status} | {$task->end_date} |\n";
        }
        return $output;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'status' => $schema->string()->description('Optional status filter (pending, completed)')->nullable(),
        ];
    }
}
