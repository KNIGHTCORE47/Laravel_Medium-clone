<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <!-- Post Title -->
    <div class="space-y-2">
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <! Select Category -->
        <div class="space-y-2">
            <x-input-label for="category" :value="__('Category')" />
            <select name="category_id" id="category_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="#"
                    class="text-gray-500 font-semibold dark:text-gray-200 bg-white/75 dark:bg-white/35" selected>
                    Select Category
                </option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <!-- Post Content -->
        <div class="space-y-2">
            <x-input-label for="content" :value="__('Content')" />
            <x-text-textarea id="content" class="block mt-1 w-full" rows="4" name="content">
                {{ old('content') }}
            </x-text-textarea>
            <x-input-error :messages="$errors->get('content')" class="mt-2" />
        </div>

        <!-- Enhanced Publish Button -->
        <div class="space-y-3">
            <x-input-label for="published_at" :value="__('Published At')"
                class="block text-sm font-semibold text-gray-900 dark:text-gray-100 tracking-wide" />

            <div class="relative group">
                <input id="published_at"
                    class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    type="datetime-local" name="published_at" value="{{ old('published_at') }}" autofocus />

                <!-- Optional calendar icon -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>

            <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
        </div>


        <!-- Post File Upload - Image -->
        <div class="space-y-2">
            <x-input-label for="image" :value="__('Upload File')" />
            <x-file-input id="image" class="block w-full mt-1" type="file" name="image" :value="old('image')" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>
        </div>
</form>
