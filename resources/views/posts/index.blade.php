<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <x-message></x-message>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-16 pb-16" style="display: flex; flex-direction: column;">

            @if (auth()->user())
                <div>
                    <a href="{{ route('posts.create') }}" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-6 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        style="float: right;">Create New Post</a>
                </div>
            @endif

            <div class="grid grid-cols-1 {{ count($posts) ? 'md:grid-cols-2' : 'md:grid-cols-1' }} gap-6 lg:gap-8">

                @forelse ($posts as $post)
                    <a href="{{ route('posts.show', $post->id) }}"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $post?->title }}</h2>
                            <h3 class="text-sm font-bold text-gray-900">
                                Author: {{ $post?->user?->name }} | Date & Time: {{ $post->created_at ? date('Y-m-d h:i A', strtotime($post->created_at)) : '' }}
                            </h3>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ Str::length($post?->body) > 300 ? Str::limit($post?->body, 300) . '.....' : $post?->body }}
                            </p>
                        </div>
                    </a>
                @empty
                    <a href="javascript:void(0)"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">No Post Found</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            </p>
                        </div>
                    </a>
                @endforelse

            </div>

            <div class="mt-5">
                {{ $posts->links('pagination::tailwind') }}
            </div>

        </div>

    </div>

</x-app-layout>
