<x-app-layout>

    <!-- Body -->
    <div class="py-4">
        <div class="max-w-7xl w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Heading Text -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-300">
                        {{ __($post->title) }}
                    </h1>

                    <!-- User Avatar with Additional Information -->
                    <div class="flex gap-x-4 items-center">
                        <!-- Avatar -->
                        @if ($post->user->avatar)
                            <x-user-avatar size_attr="w-16 h-16" :user="$post->user" />
                        @endif

                        <!-- User Info -->
                        <x-alpine-follow-wrapper :user="$post->user" style_class="mt-4 flex flex-col">
                            <div>
                                <a href="{{ route('profile.show', $post->user->username ?? '') }}"
                                    class="text-lg text-gray-900 dark:text-gray-300 uppercase font-semibold hover:text-gray-600 dark:hover:text-gray-400 hover:underline">
                                    {{ __($post->user->name) }}
                                </a>
                                <span>&nbsp;&middot;&nbsp;</span>
                                <button x-text="following ? 'Unfollow' : 'Follow'" @click="follow()"
                                    :class="{ 'text-red-500 hover:text-red-700': following }"
                                    class="text-green-500 text-sm capitalize {{ Auth::user() && Auth::user()->id !== $post->user->id ? '' : 'disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:text-emerald-500' }}"
                                    {{ Auth::user() && Auth::user()->id !== $post->user->id ? '' : 'disabled' }}>
                                </button>
                            </div>

                            <span class="text-sm text-gray-600 dark:text-gray-400"> {{ __($post->readTime()) }}
                                &nbsp;&middot;&nbsp;
                                {{ __($post->created_at->format('M d, Y')) }}</span>
                        </x-alpine-follow-wrapper>
                    </div>

                    <!-- Like, Clap and Share Buttons -->
                    <div class="mt-4 py-4 border-y border-gray-200 dark:border-gray-700">
                        <div class="flex gap-x-4 items-center justify-between px-4">
                            <!-- Logic | If Public Profile User == Autenticated User then Hide like button -->
                            @if (Auth::user() && Auth::user()->id !== $post->user->id)
                                <!-- Like Button -->
                                <x-alpine-like-wrapper :post="$post" />
                            @else
                                <!-- Likes Count [Only For Public Profile] -->
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $post->likes()->count() }}&nbsp;&nbsp;Likes</p>
                            @endif


                            <div class="flex gap-x-4">

                                <!-- Logic | If Public Profile User == Autenticated User then only Show Edit and Delete Button -->

                                @if (Auth::user() && Auth::user()->id === $post->user->id)
                                    <!-- Edit Post -->
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <!-- Delete Post -->
                                    <form method="post" action="{{ route('posts.destroy', $post) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this post?')"
                                            class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <!-- Share Post -->
                                <a href="#" class="text-gray-100 dark:text-gray-400 hover:text-emerald-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="mt-4">
                        <!-- Content Image -->
                        <img src="{{ $post->getImageUrl() }}" alt="" srcset="" class="w-1/3 object-cover">

                        <!-- Content Body -->
                        <p class="text-sm text-gray-700 dark:text-gray-200 mt-4">
                            {{ __($post->content) }}
                        </p>
                    </div>

                    <!-- Post Tags | Categories -->
                    <p
                        class="text-sm text-gray-700 dark:text-gray-200 mt-4 bg-gray-400 dark:bg-gray-600 py-2 px-4 rounded-full w-fit">
                        {{ __($post->category->name) }}
                    </p>
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
