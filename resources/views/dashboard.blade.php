<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'Total tasks' => $totalTasks,
                    'Completed' => $completedTasks,
                    'Pending' => $pendingTasks,
                    'In progress' => $inProgressTasks,
                    'High priority pending' => $highPriorityPendingTasks,
                    'Due this week' => $tasksDueThisWeek,
                ] as $label => $value)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Tasks</h3>
                        @if (!Auth::user()->isGuest())
                            <a href="{{ route('tasks.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">New task</a>
                        @endif
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentTasks as $task)
                            <a href="{{ route('tasks.show', $task) }}" class="block border border-gray-200 dark:border-gray-700 rounded-md p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $task->title }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Due {{ $task->formatted_due_date ?? 'No date' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $task->status_badge }}">{{ str_replace('_', ' ', $task->status->value) }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No tasks to show.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
