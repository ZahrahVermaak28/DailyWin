@php
    $selectedCategories = old('categories', $task->exists ? $task->categories->pluck('id')->all() : []);
@endphp

<div class="space-y-6">
    <div>
        <x-input-label for="title" value="Title" />
        <x-text-input id="title" name="title" class="block mt-1 w-full" value="{{ old('title', $task->title) }}" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $task->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $task->status?->value ?? $task->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="priority" value="Priority" />
            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('priority', $task->priority?->value ?? $task->priority) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="due_date" value="Due Date" />
            <x-text-input id="due_date" name="due_date" type="date" class="block mt-1 w-full" value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}" />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="assigned_to" value="Assign To" />
        <select id="assigned_to" name="assigned_to" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" @disabled(!Auth::user()->isAdmin())>
            <option value="">Unassigned</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected((int) old('assigned_to', $task->assigned_to) === $user->id)>{{ $user->name }} ({{ str_replace('_', ' ', $user->role->value) }})</option>
            @endforeach
        </select>
        @if (!Auth::user()->isAdmin())
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Team members create tasks for themselves. Admins can assign tasks to other users.</p>
        @endif
        <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
    </div>

    <div>
        <x-input-label value="Categories" />
        <div class="mt-2 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($categories as $category)
                <label class="flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-700 p-3 text-sm text-gray-700 dark:text-gray-200">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $selectedCategories)) class="rounded border-gray-300 text-indigo-600 shadow-sm">
                    <span>{{ $category->name }}</span>
                </label>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No categories have been created yet.</p>
            @endforelse
        </div>
        <x-input-error :messages="$errors->get('categories')" class="mt-2" />
    </div>

    <div class="flex items-center gap-3">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
        <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancel</a>
    </div>
</div>
