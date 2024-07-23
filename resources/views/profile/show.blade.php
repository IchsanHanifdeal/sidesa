<x-noheader-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden rounded-xl shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-10 bg-white  border-b border-gray-200">
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-10">
                    <div class="w-full sm:w-1/4 flex justify-center sm:justify-start">
                        @if ($user->image)
                            <img class="w-24 h-24 rounded-full"
                                src="{{ asset('storage/images/' . $user->image) }}" alt="Profile Picture" />
                        @else
                            <div class="w-24 h-24 rounded-full flex items-center justify-center bg-gray-200">
                                <img class="w-24 h-24 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF" />
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center sm:w-3/4">
                        <h1 class="text-3xl font-semibold text-center">{{ $user->name }}</h1>
                        <p class="text-gray-500 text-sm mt-2 w-fit px-3 py-2 mx-auto border rounded-md border-black text-center">{{ $user->role . ' ' . $user->nama }}</p>
                        <p class="text-gray-500 text-center mt-3 text-sm ">{{ $user->alamat }}</p>
                        <p class="text-gray-500 text-sm text-center">{{ $user->no_hp }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-md flex flex-col gap-3 w-full text-gray-800 mx-auto mt-5 overflow-hidden md:max-w-2xl">
            <h1 class="text-2xl font-semibold">Postingan</h1>

                @forelse ($posts as $post)
                    <div
                    class="p-4 bg-white md:p-6 rounded-xl shadow-md hover:bg-gray-200">
                        <div class="flex items-start gap-2">
                            <div class="md:flex-shrink-0">
                                @if ($post->creator_image)
                                    <img class="rounded-full h-8 w-8"
                                        src="{{ asset('storage/images/' . $post->creator_image) }}" />
                                @else
                                    <div class="w-8 rounded-full">
                                        <img class="rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ $post->creator_name }}&color=7F9CF5&background=EBF4FF" />
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a
                                href="{{route('profile.show', $post->creator_id)}}"
                                class="font-semibold">
                                    {{ $post->creator_name }}
                                </a>
                                <p class="text-gray-500 text-sm">
                                    @php
                                        \Carbon\Carbon::setLocale('id');
                                        $human = \Carbon\Carbon::parse($post->updated_at)->diffForHumans();
                                        echo $human;
                                    @endphp
                                </p>
                            </div>
                        </div>

                        @if ($post->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/images/' . $post->photo) }}" alt="image"
                                    class="rounded-lg w-full h-48 object-cover">
                            </div>
                        @endif

                        <a
                        href="{{route('posts.show', $post->id)}}"
                        class="mt-3 text-sm">
                            {{ $post->content }}
                        </a>

                        <div class="flex items-center justify-between w-full mt-3">
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex gap-2">
                                    <button
                                        class="like-button {{ $post->is_liked ? 'text-red-500' : 'text-black' }} flex gap-1 items-center hover:text-red-500"
                                        data-post-id="{{ $post->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path
                                                d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                        </svg>
                                        <span class="like-count">{{ $post->like_count }}</span>
                                    </button>
                                    <button class="text-sky-500 flex gap-1 items-center hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $post->comment_count }}
                                    </button>
                                </div>
                            </div>
                            <div>
                                @if ($post->creator_id == Auth::id())
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-600 flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6 text-red-500">
                                                <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 md:p-6 rounded-xl">
                        <p class="text-center">Belum ada postingan</p>
                    </div>
                @endforelse
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', async () => {
                    const postId = button.getAttribute('data-post-id');
                    const response = await fetch(`/like/${postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        const likeCountSpan = button.querySelector('.like-count');
                        likeCountSpan.textContent = data.like_count;

                        // Toggle classes based on is_liked value
                        if (data.liked) {
                            button.classList.add('text-red-500');
                            button.classList.remove('text-black');
                        } else {
                            button.classList.remove('text-red-500');
                            button.classList.add('text-black');
                        }
                    }
                });
            });
        });
    </script>
</x-noheader-layout>
