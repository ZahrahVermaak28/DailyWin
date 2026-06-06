<?php

namespace App\Http\Controllers;

use App\Models\TaskAZU;
use App\Models\UserAZU;
use App\Models\CategoryAZU;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreTaskRequestAZU;
use App\Http\Requests\UpdateTaskRequestAZU;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskControllerAZU extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', TaskAZU::class);

        $user = $request->user();
        $tasks = TaskAZU::query()
            ->with(['creator', 'assignee', 'categories'])
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('created_by', $user->id)
                        ->orWhere('assigned_to', $user->id);
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->priority))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        Gate::authorize('create', TaskAZU::class);

        return view('tasks.create', [
            'task' => new TaskAZU(['status' => 'pending', 'priority' => 'medium']),
            'users' => UserAZU::query()->where('role', '!=', 'guest')->orderBy('name')->get(),
            'categories' => CategoryAZU::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreTaskRequestAZU $request): RedirectResponse
    {
        Gate::authorize('create', TaskAZU::class);

        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $data['assigned_to'] = $request->user()->isAdmin() ? ($data['assigned_to'] ?? null) : Auth::id();

        $task = TaskAZU::create($data);
        $task->categories()->sync($request->input('categories', []));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(TaskAZU $task): View
    {
        Gate::authorize('view', $task);

        $task->load(['creator', 'assignee', 'categories']);

        return view('tasks.show', compact('task'));
    }

    public function edit(TaskAZU $task): View
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', [
            'task' => $task->load('categories'),
            'users' => UserAZU::query()->where('role', '!=', 'guest')->orderBy('name')->get(),
            'categories' => CategoryAZU::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateTaskRequestAZU $request, TaskAZU $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $data = $request->validated();

        if (!$request->user()->isAdmin()) {
            unset($data['assigned_to']);
        }

        $task->update($data);
        $task->categories()->sync($request->input('categories', []));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, TaskAZU $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $task->update($validated);

        return back()->with('success', 'Task status updated.');
    }

    public function destroy(TaskAZU $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
