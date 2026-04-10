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
        $this->authorize('viewAny', Task::class);
        $tasks = $company->tasks;
        return view('tasks.index', compact('tasks', 'company'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', Task::class);
        $users = $company->users;
        $tasks = $company->tasks;
        return view('tasks.create', compact('company', 'users', 'tasks'));
    }

    public function store(StoreTaskRequest $request, Company $company)
    {
        $this->authorize('create', Task::class);
        $task = $company->tasks()->create($request->validated());
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task created successfully');
    }

    public function show(Company $company, Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task', 'company'));
    }

    public function edit(Company $company, Task $task)
    {
        $this->authorize('view', $task);
        $users = $company->users;
        $tasks = $company->tasks()->where('id', '!=', $task->id)->get();
        return view('tasks.edit', compact('task', 'company', 'users', 'tasks'));
    }

    public function update(UpdateTaskRequest $request, Company $company, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Company $company, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task deleted successfully');
    }

    public function restore(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $task);
        $task->restore();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task restored successfully');
    }

    public function forceDelete(Company $company, $id)
    {
        $task = $company->tasks()->onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $task);
        $task->forceDelete();
        return redirect()->route('tasks.index', $company->slug)
            ->with('success', 'Task permanently deleted');
    }
}