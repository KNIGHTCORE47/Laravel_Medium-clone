<x-app-layout>

    <!-- Body -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Categories -->
            @if (request()->path() === 'posts/@myPosts')
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-300 pb-8">
                        My Posts
                    </h1>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <x-category-tabs />
                    </div>
                </div>
            @endif

            <!-- Posts | Cards -->
            @if ($posts->count() > 0)
                <!-- Posts | Cards -->
                <div class="mt-6 space-y-6 flex flex-col items-center">
                    @foreach ($posts as $post)
                        <x-post-items :post="$post" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->onEachSide(1)->links() }}
                </div>
            @else
                <div
                    class="h-96 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6 flex items-center justify-center">
                    <p class="p-6 text-gray-900 dark:text-gray-100">
                        No posts found.
                    </p>
                </div>
            @endif
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
