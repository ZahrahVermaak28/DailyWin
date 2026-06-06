<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Admin Area</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Tasks</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $taskCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Users</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $userCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Categories</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $categoryCount }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Recent Tasks</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($tasks as $task)
                            <a href="{{ route('tasks.show', $task) }}" class="block text-sm text-indigo-600 hover:text-indigo-900">{{ $task->title }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Recent Users</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($users as $user)
                            <div class="text-sm text-gray-700 dark:text-gray-300">{{ $user->name }} - {{ str_replace('_', ' ', $user->role->value) }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Category Management</h3>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Manage categories</a>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($categories as $category)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-800">{{ $category->name }} ({{ $category->tasks_count }})</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
