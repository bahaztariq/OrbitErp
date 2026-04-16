<?php

namespace App\Ai\Tools\Tasks;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateTaskTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Create a new task record.';
    }

    public function handle(Request $request): Stringable|string
    {
        $task = $this->company->tasks()->create($request->all());
        return "Successfully created task: {$task->title} (ID: {$task->id})";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Task title')->required(),
            'priority' => $schema->string()->description('Priority (low, medium, high)')->nullable(),
            'status' => $schema->string()->description('Status (pending, completed)')->nullable(),
            'end_date' => $schema->string()->description('Due date (YYYY-MM-DD)')->nullable(),
        ];
    }
}
