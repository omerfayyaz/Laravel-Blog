<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <x-message></x-message>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-10 pb-16" style="display: flex; flex-direction: column;">

            <form method="get" action="{{ route('posts.index') }}" class="flex items-center gap-4 mb-10">

                <div style="flex: 1;">
                    <x-text-input id="search" name="search" type="text" class="block w-full" :value="$request->search" autofocus placeholder="Search Here" />
                </div>


                <div class="flex items-center gap-4">
                    <x-primary-button text_size="text-sm">{{ __('Search') }}</x-primary-button>
                </div>

                @if (auth()->user())
                    <div class="flex items-center gap-4">
                        <x-link-button href="{{ route('posts.create') }}" text_size="text-sm">{{ __('Create New Post') }}</x-link-button>
                    </div>
                @endif
            </form>



            <div class="grid grid-cols-1 {{ count($posts) ? 'md:grid-cols-2' : 'md:grid-cols-1' }} gap-6 lg:gap-8">
                @forelse ($posts as $post)
                    <x-post-card href="{{ route('posts.show', $post->id) }}">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $post?->title }}</h2>
                            <h3 class="text-sm font-bold text-gray-900">
                                Author: {{ $post?->user?->name }} | Date & Time: {{ $post->created_at ? date('Y-m-d h:i A', strtotime($post->created_at)) : '' }}
                            </h3>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ Str::length($post?->body) > 300 ? Str::limit($post?->body, 300) . '.....' : $post?->body }}
                            </p>
                        </div>
                    </x-post-card>
                @empty
                    <x-post-card href="javascript:void(0)">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">No Post Found</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed"></p>
                        </div>
                    </x-post-card>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $posts->links('pagination::tailwind') }}
            </div>

        </div>
    </div>
</x-app-layout>
