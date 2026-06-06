<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $task->title }}</h2>
            @can('update', $task)
                <a href="{{ route('tasks.edit', $task) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Edit</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="flex flex-wrap gap-2">
                    <span class="px-2 py-1 text-xs rounded-full {{ $task->status_badge }}">{{ str_replace('_', ' ', $task->status->value) }}</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $task->priority_badge }}">{{ $task->priority->value }} priority</span>
                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Due {{ $task->formatted_due_date ?? 'No date' }}</span>
                </div>

                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $task->description ?: 'No description provided.' }}</p>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-500">Created by</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $task->creator?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Assigned to</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $task->assignee?->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-gray-500">Categories</dt>
                        <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $task->categories->pluck('name')->join(', ') ?: '-' }}</dd>
                    </div>
                </dl>

                @can('update', $task)
                    <form method="POST" action="{{ route('tasks.update-status', $task) }}" class="flex flex-wrap items-end gap-3">
                        @csrf
                        @method('PATCH')
                        <div>
                            <x-input-label for="status" value="Quick Status" />
                            <select id="status" name="status" class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                    <option value="{{ $value }}" @selected($task->status->value === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button>Update Status</x-primary-button>
                    </form>
                @endcan

                @can('delete', $task)
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Delete Task</x-danger-button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
