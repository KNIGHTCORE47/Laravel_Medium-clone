<x-app-layout>

    <!-- Header -->
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot> --}}

    <!-- Body -->
    <div class="flex items-center justify-center w-full h-screen transition-opacity opacity-100 duration-750 lg:grow">
        <div class="max-w-4xl w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header Text -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-300 text-center">{{ __('Edit Post') }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-1">
                        {{ __('Edit an existing post') }}</p>

                    <!-- Post Form -->
                    <x-post-edit-form :categories="$categories" :post="$post" :oldImage="$oldImage" />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

{{-- 

** Customized Pagination

[commandline]
php artisan vendor:publish --tag=laravel-pagination

[usage] [default tailwind]

[blade]
{{ $posts->links() }}

[blade]
{{ $posts->links('pagination::tailwind') }}

[blade]
{{ $posts->links('pagination::bootstrap-4') }}

- --}}
