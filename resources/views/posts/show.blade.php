<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-1000 leading-tight">
            {{ __('Blog->Post') }}
        </h2>
    </x-slot>

    <x-message></x-message>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <section>
                        <header class="flex justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">
                                    {{ $post?->title }}
                                </h1>
                                <h3 class="text-base font-bold text-gray-900">
                                    Author: {{ $post?->user?->name }} | Date & Time: {{ $post->created_at ? date('Y-m-d h:i A', strtotime($post->created_at)) : '' }}
                                </h3>
                            </div>

                            @if (auth()->user() && auth()->id() == $post?->user_id)
                                <div class="flex">

                                    <a href="{{ route('posts.edit', $post?->id) }}" type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-6 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit Post</a>
                                    <form method="POST" action="{{ route('posts.destroy', $post?->id) }}">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-6 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Delete Post</button>
                                    </form>
                                </div>
                            @endif
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

                @if (auth()->user())
                    <form method="post" action="{{ route('comments.store', $post?->id) }}" class="mt-6 mb-10 space-y-6">
                        @csrf

                        <div class="flex justify-between">
                            <h1 class="text-xl font-bold text-gray-900">
                                Comments
                            </h1>

                            <x-primary-button>{{ __('Save Comment') }}</x-primary-button>
                        </div>

                        <div>
                            <x-text-area id="body" name="body" type="text" class="mt-1 block w-full" :text_value="old('body')" autofocus autocomplete="body" style="min-height: 100px;" />
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>
                    </form>
                @else
                    <h1 class="text-xl font-bold text-gray-900 mb-4">
                        Comments
                    </h1>
                @endif

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
