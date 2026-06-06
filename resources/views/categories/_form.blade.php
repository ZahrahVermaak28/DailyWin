<div class="space-y-6">
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" class="block mt-1 w-full" value="{{ old('name', $category->name) }}" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex items-center gap-3">
        <x-primary-button>{{ $buttonText }}</x-primary-button>
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Cancel</a>
    </div>
</div>
