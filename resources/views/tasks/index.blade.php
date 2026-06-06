<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">New Task</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="mb-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <form method="GET" class="grid gap-4 sm:grid-cols-3">
                    <select name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">All statuses</option>
                        @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="priority" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">All priorities</option>
                        @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('priority') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-primary-button>Filter</x-primary-button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Due</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Assigned</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Categories</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($tasks as $task)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $task->title }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $task->status_badge }}">{{ str_replace('_', ' ', $task->status->value) }}</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full {{ $task->priority_badge }}">{{ $task->priority->value }}</span></td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $task->formatted_due_date ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $task->categories->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        @can('update', $task)
                                            <a href="{{ route('tasks.edit', $task) }}" class="ms-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No tasks found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $tasks->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
