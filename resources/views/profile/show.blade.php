<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Public Profile') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex">

                    <!-- Main Content -->
                    <div class="flex-1 pr-8">
                        <h1
                            class="text-3xl font-semibold text-gray-700 dark:text-gray-200 pb-4 border-b border-gray-600 capitalize">
                            {{ $user->name }}
                        </h1>

                        <!-- Posts -->
                        @if ($posts->count() > 0)
                            <!-- Posts -->
                            <div class="mt-6 space-y-6 flex flex-col items-center">
                                @foreach ($posts as $post)
                                    <x-post-items :post="$post" size_attr="max-w-6xl" />
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

                    <!-- Sidebar -->
                    <x-alpine-follow-wrapper :user="$user"
                        style_class="bg-gray-100 dark:bg-gray-900 w-1/4 border-l border-gray-600 flex flex-col items-center justify-center gap-y-3">
                        <x-user-avatar size_attr="w-24 h-24" :user="$user" />

                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 uppercase">
                            {{ $user->name }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span x-text="followersCount"></span> Followers
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold">
                            {{ $user->bio }}
                        </p>

                        <!-- Follow Button -->
                        <div class="flex gap-x-2 items-center">
                            <!-- On the basis of authentication and ownner user id the button will disable or enable -->
                            <button
                                class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline {{ Auth::user() && Auth::user()->id !== $user->id ? '' : 'disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-emerald-500' }}"
                                type="button" id="followButton" onclick="console.log('Follow Button Clicked')"
                                {{ Auth::user() && Auth::user()->id !== $user->id ? '' : 'disabled' }}
                                x-text="following ? 'Unfollow' : 'Follow'" @click="follow()"
                                :class="{ 'bg-red-500 hover:bg-red-700': following }"> </button>

                            <a href="#"
                                class="text-gray-300 dark:text-gray-100 bg-emerald-500 hover:bg-emerald-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </a>
                        </div>

                        <hr class="w-2/3 border-gray-600 mt-4" />

                        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            Following!!
                        </h2>

                        <!-- Following List -->
                        <div class="flex flex-col gap-y-3 mb-4">
                            @forelse ($user->following as $following)
                                <a href="{{ route('profile.show', $following) }}"
                                    class="flex items-center gap-x-8 p-2 bg-gray-800 dark:bg-gray-600 rounded-full hover:bg-gray-700 dark:hover:bg-gray-500">
                                    <x-user-avatar size_attr="w-10 h-10" margin_class="mt-0" :user="$following" />
                                    <p class="text-sm text-gray-600 dark:text-gray-300 pr-10">
                                        {{ $following->name }}
                                    </p>
                                </a>
                            @empty
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-semibold">{{ $user->name }}</span> is not following anyone.
                                </p>
                            @endforelse
                        </div>
                    </x-alpine-follow-wrapper>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
