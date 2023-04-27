<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-1000 leading-tight">
            {{ __('Blog Home -> Post') }}
        </h2>
    </x-slot>

    <x-message></x-message>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <section>
                        <header class="">
                            <div class="flex justify-between">
                                <h1 class="text-3xl font-bold text-gray-900">
                                    {{ $post?->title }}
                                </h1>

                                @if (auth()->user() && auth()->id() == $post?->user_id)
                                    <div class="flex gap-4">

                                        <x-link-button href="{{ route('posts.edit', $post?->id) }}">{{ __('Edit Post') }}</x-link-button>

                                        <form method="POST" action="{{ route('posts.destroy', $post?->id) }}">
                                            @csrf
                                            @method('delete')

                                            <x-danger-button>{{ __('Delete Post') }}</x-danger-button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-base font-bold text-gray-900">
                                Author: {{ $post?->user?->name }} | Date & Time: {{ $post->created_at ? date('Y-m-d h:i A', strtotime($post->created_at)) : '' }}
                            </h3>

                        </header>

                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg leading-relaxed">
                            {{ $post?->body }}
                        </p>
                    </section>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-12">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                {{-- @if (auth()->user()) --}}
                <form method="post" action="{{ route('comments.store', $post?->id) }}" class="mt-6 mb-10 space-y-6">
                    @csrf

                    <div class="flex justify-between">
                        <h1 class="text-xl font-bold text-gray-900">
                            Comments
                        </h1>

                        <x-primary-button>{{ __('Save Comment') }}</x-primary-button>
                    </div>

                    @if (!auth()->user())
                        <div>
                            <x-input-label for="user_name" :value="__('Name')" />
                            <x-text-input id="user_name" name="user_name" type="text" class="mt-1 block w-full" :value="old('user_name')" autofocus autocomplete="user_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
                        </div>
                    @endif

                    <div>
                        <x-input-label for="body" :value="__('Comment')" />
                        <x-text-area id="body" name="body" type="text" class="mt-1 block w-full" :text_value="old('body')" autofocus autocomplete="body" style="min-height: 100px;" />
                        <x-input-error class="mt-2" :messages="$errors->get('body')" />
                    </div>
                </form>

                @forelse ($post?->comments as $comment)
                    <div class="mb-6">
                        <section>
                            <header class="flex justify-between">
                                <h3 class="text-md font-semibold text-gray-700">
                                    {{ $comment?->user_name }} | Date & Time: {{ $comment?->created_at ? date('Y-m-d h:i A', strtotime($comment?->created_at)) : '' }}
                                </h3>
                            </header>

                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ $comment?->body }}
                            </p>
                        </section>
                    </div>
                @empty
                    <div class="mb-6">
                        <section>
                            <header class="flex justify-between">
                                <h3 class="text-md font-semibold text-gray-700">
                                    No comments found for this post.
                                </h3>
                            </header>
                        </section>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

</x-app-layout>
