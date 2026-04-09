<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Company;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        $this->authorize('viewAny', Task::class);
        $tasks = $company->tasks;
        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'data' => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Company $company)
    {
        $this->authorize('create', Task::class);
        $task = $company->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Task $task)
    {
        $this->authorize('view', $task);
        return response()->json([
            'message' => 'Task retrieved successfully',
            'data' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Company $company, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $task);
        $task->restore();

        return response()->json([
            'message' => 'Task restored successfully',
            'data' => $task
        ], 200);
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $task);
        $task->forceDelete();

        return response()->json([
            'message' => 'Task permanently deleted'
        ], 200);
    }
}