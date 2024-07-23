<x-noheader-layout>
    <div class="flex w-full gap-2 flex-wrap">
        <div class="mx-auto bg-white px-3 rounded-xl shadow-md overflow-hidden w-full">
            <div class="md:flex w-full">
                <form method="post" enctype="multipart/form-data" action="{{ route('posts.store') }}" class="w-full p-4">
                    <input type="hidden" name="idGroup" value="{{ $idGroup }}">
                    <div class="mb-4 flex w-full items-start gap-2">
                        <div class="md:flex-shrink-0">
                            @if (Auth::user()->image)
                                <img class="rounded-full h-12 w-12"
                                    src="{{ asset('storage/images/' . Auth::user()->image) }}" />
                            @else
                                <div class="w-12 h-12 rounded-full">
                                    <img class="rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" />
                                </div>
                            @endif
                        </div>

                        <div class="flex w-full flex-col gap-3">
                            <div class="w-full flex gap-3 items-start">
                                <textarea id="content" required name="content" rows="7" placeholder="Apa yang Anda pikirkan?"
                                    class="form-textarea block w-full text-black placeholder:text-gray-500 bg-gray-100 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                            </div>
                            <div id="image-preview">
                                <img id="preview" src="#" alt="Image Preview"
                                    class="hidden w-32 h-32 object-cover rounded-lg">
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="for_sale" id="for_sale" class="p-2 rounded-lg">
                                <label for="for_sale">Dijual</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 items-center justify-end">
                        @csrf
                        <div class="flex gap-3 items-center">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                           
                            <label for="image"
                                class="flex gap-2 items-center cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Foto
                            </label>

                            <script>
                                document.getElementById('image').addEventListener('change', function(event) {
                                    const [file] = event.target.files;
                                    if (file) {
                                        const preview = document.getElementById('preview');
                                        preview.src = URL.createObjectURL(file);
                                        preview.classList.remove('hidden');

                                        preview.style.width = '200px';
                                        preview.style.height = '200px';
                                    }
                                });
                            </script>

                        </div>
                        <div>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                Kirim
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col gap-3 w-full text-gray-800 mx-auto mt-5 overflow-hidden">
            @if ($tab == 'Umum')
                @forelse ($posts as $post)
                    <div class="p-4 bg-white md:p-6 rounded-xl shadow-md hover:bg-gray-200">
                        <div class="flex items-start gap-2">
                            <div class="md:flex-shrink-0">
                                @if ($post->creator_image)
                                    <img class="rounded-full h-12 w-12"
                                        src="{{ asset('storage/images/' . $post->creator_image) }}" />
                                @else
                                    <div class="w-12 h-12 rounded-full">
                                        <img class="rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ $post->creator_name }}&color=7F9CF5&background=EBF4FF" />
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a 
                                href="{{ route('profile.show', $post->creator_id) }}" class="font-semibold">
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
                                    class="rounded-lg w-full h-56 object-cover">
                            </div>
                        @endif

                        <div class="mt-5">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-sm">
                                {{ $post->content }}
                            </a>
                        </div>

                    
                        <div class="flex items-center justify-between w-full mt-3">
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex gap-3">
                                    <button
                                        class="like-button {{ $post->is_liked ? 'text-red-500' : 'text-black' }} flex gap-1 items-center hover:text-red-500"
                                        data-post-id="{{ $post->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-8 h-8">
                                            <path
                                                d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                        </svg>
                                        <span class="like-count font-bold">{{ $post->like_count }}</span>
                                    </button>
                                    <a 
                                    href="{{ route('posts.show', $post->id) }}" 
                                    class="text-sky-500 font-bold flex gap-1 items-center hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-8 h-8">
                                            <path fill-rule="evenodd"
                                                d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $post->comment_count }}
                                    </a>

                                </div>
                            </div>
                            <div class="flex gap-2 flex-row-reverse items-center">
                                @if ($post->creator_id == Auth::id())
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="text-red-500 font-bold hover:text-red-600 flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6 text-red-500">
                                                <path fill-rule="evenodd"
                                                    d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            @if ($post->for_sale)
                                            @php 
                                                $creator = App\Models\User::find($post->creator_id);
                                                $customMessage = "Halo, saya tertarik dengan " . $post->content . ". Bolehkah saya bertanya lebih lanjut?";
                                                $msg = "https://wa.me/{$creator->no_hp}?text={$customMessage}";
                                            @endphp
                                                <a href="{{ $msg }}" target="_blank"
                                                    class="px-3 py-2 flex gap-2 items-center text-sm w-fit rounded-md bg-green-500 text-white">
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1024px-WhatsApp.svg.png"
                                                        alt="chat" class="w-5 h-5 object-cover">
                                                    Hubungi Penjual
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 md:p-6 rounded-xl">
                        <p class="text-center">Belum ada postingan</p>
                    </div>
                @endforelse

            @endif
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
