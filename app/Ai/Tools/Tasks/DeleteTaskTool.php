<?php

namespace App\Ai\Tools\Tasks;

use App\Models\Company;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class DeleteTaskTool implements Tool
{
    public function __construct(protected Company $company) {}

    public function description(): Stringable|string
    {
        return 'Delete a task by ID.';
    }

    public function handle(Request $request): Stringable|string
    {
        $id = $request->get('id');
        $task = $this->company->tasks()->find($id);

        if (!$task) return "Error: Task not found.";

        $title = $task->title;
        $task->delete();
        return "Successfully deleted task: {$title}";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('ID of the task to delete')->required(),
        ];
    }
}
