@props(['size_attr' => 'max-w-5xl', 'post'])

<div class="w-full {{ $size_attr }}">
    <div class="group flex flex-col
            bg-slate-800/60 backdrop-blur-sm
            border border-slate-700/50 rounded-xl
            shadow-lg shadow-slate-900/20
            hover:shadow-xl hover:shadow-slate-900/30
            md:flex-row
            overflow-hidden
            transition-all duration-300 ease-out
            hover:scale-[1.01] hover:bg-slate-800/80
            hover:border-slate-600/60
            cursor-pointer"
        onclick="handleCardClick(event, '{{ route('posts.show', ['username' => $post->user->username, 'post' => $post]) }}')">

        <!-- Image Container -->
        <div
            class="relative overflow-hidden
                w-full md:w-64 lg:w-72
                aspect-[16/10] md:aspect-[4/3]
                rounded-t-xl md:rounded-none md:rounded-l-xl
                bg-slate-700/30">
            <img src="{{ $post->getImageUrl('preview') }}" alt="{{ $post->title ?? 'Post Image' }}"
                class="object-cover w-full h-full
                        transition-all duration-500 ease-out
                        group-hover:scale-105
                        filter brightness-90 group-hover:brightness-100">

            <!-- Subtle overlay for better text contrast -->
            <div
                class="absolute inset-0 bg-gradient-to-t 
                    from-slate-900/20 via-transparent to-transparent
                    opacity-60 group-hover:opacity-40
                    transition-opacity duration-300">
            </div>
        </div>

        <!-- Content Container -->
        <div
            class="flex flex-col justify-center
                    p-6 md:p-8
                    flex-1
                    min-h-[160px]">

            <!-- Title -->
            <h5
                class="mb-3 text-xl md:text-2xl font-semibold
                    text-slate-100 
                    group-hover:text-white
                    transition-colors duration-200
                    leading-tight
                    line-clamp-2">
                {{ __($post->title) }}
            </h5>

            <!-- Content Preview -->
            <p
                class="mb-4 text-sm md:text-base
                    text-slate-300
                    group-hover:text-slate-200
                    line-clamp-3 leading-relaxed
                    transition-colors duration-200">
                {{ __(Str::words($post->content, 25)) }}
            </p>

            <!-- Read More Indicator -->
            <div class="flex items-center justify-between">
                <div
                    class="flex items-center text-xs
                    text-slate-400 group-hover:text-slate-300
                    opacity-0 group-hover:opacity-100
                    transform translate-y-1 group-hover:translate-y-0
                    transition-all duration-300">
                    <span class="font-medium mr-2">
                        Continue reading
                    </span>
                    <svg class="w-4 h-4 
                        transform group-hover:translate-x-1
                        transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center gap-x-4">
                        <span class="text-sm text-slate-600 dark:text-slate-400">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>

                        <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-x-1">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path
                                        d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                </svg>
                            </span>

                            {{ $post->likes_count }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400">Published By -
                        <a href="{{ route('profile.show', $post->user->username) }}"
                            class="font-medium text-gray-800 dark:text-gray-200 hover:underline"
                            onclick="event.stopPropagation()">
                            {{ '@' }}{{ $post->user->username }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleCardClick(event, url) {
        // Don't navigate if clicking on a link or interactive element
        if (event.target.tagName === 'A' || event.target.closest('a')) {
            return;
        }
        window.location.href = url;
    }
</script>
