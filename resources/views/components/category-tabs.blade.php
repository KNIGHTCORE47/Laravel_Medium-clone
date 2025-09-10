@if ($categories->count() > 0)
    <ul class="flex flex-wrap justify-center text-sm font-medium text-center text-gray-500 dark:text-gray-400">
        <li class="me-2">
            <a href="{{ route('posts') }}"
                class="inline-block px-4 py-3 rounded-lg {{ request('category') ? 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' : 'text-white bg-blue-600 active' }}"
                aria-current="page">
                All
            </a>
        </li>

        @foreach ($categories as $category)
            <li class="me-2">
                <a href="{{ route('posts.byCategory', $category) }}"
                    class="inline-block px-4 py-3 rounded-lg {{ Route::currentRouteName() === 'posts.byCategory' && request('category')->id == $category->id ? 'text-white bg-blue-600' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                    {{ __($category->name) }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-center text-gray-500 dark:text-gray-400">No categories found</p>
@endif


{{-- 

** Create of components

[commandline] 
[Creation of both view and component controller]
php artisan make:component CategoryTabs

[commandline] 
[Creation only view]
php artisan make:component CategoryTabs --view

--}}
