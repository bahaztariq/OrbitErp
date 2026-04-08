<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Company;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Company $company)
    {
        $tasks = $company->tasks;
        return view('tasks.index', compact('tasks', 'company'));
    }

    public function create(Company $company)
    {
        return view('tasks.create', compact('company'));
    }

    public function store(StoreTaskRequest $request, Company $company)
    {
        $task = $company->tasks()->create($request->validated());
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task created successfully');
    }

    public function show(Company $company, Task $task)
    {
        return view('tasks.show', compact('task', 'company'));
    }

    public function edit(Company $company, Task $task)
    {
        return view('tasks.edit', compact('task', 'company'));
    }

    public function update(UpdateTaskRequest $request, Company $company, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Company $company, Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $task->forceDelete();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task permanently deleted');
    }
}
