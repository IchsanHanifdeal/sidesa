<x-noheader-layout>
    <!-- Detail Post -->
    <div class="p-6 bg-white">
        <div class="flex items-center space-x-4 mb-4">
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
                <h2 class="font-semibold">{{ $post->creator_name }}</h2>
                @php
                \Carbon\Carbon::setLocale('id');
                $human = \Carbon\Carbon::parse($post->updated_at)->diffForHumans();
                echo $human;
            @endphp

            </div>
        </div>
        <p>{{ $post->content }}</p>

        @if ($post->photo)
        <div class="mt-3">
            <img src="{{ asset('storage/images/' . $post->photo) }}" alt="image"
                class="rounded-lg w-full h-48 object-cover">
        </div>
    @endif
        <div class="flex gap-2 items-center mt-5">
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



    <!-- Daftar Komentar -->
    <div class="p-6 bg-white mt-4 h-screen overflow-y-auto">
        <form action="{{ route('comments.store') }}" method="POST" id="submit-comment">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="content" rows="3" class="w-full border rounded-md px-3 py-2 focus:outline-none" placeholder="Tulis komentar anda..."></textarea>
            <button type="submit" class="bg-blue-500 flex gap-2 items-center text-white px-4 py-2 mt-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                  </svg>
                Kirim</button>
        </form>

        <h2 class="text-xl font-semibold py-5">Riwayat Komentar</h2>
        <div class="mb-12 pb-12">

        @foreach ($comments as $comment)
            <div class="flex items-start mb-4">
                <div class="md:flex-shrink-0">
                    @if ($comment->creator_image)
                        <img class="rounded-full h-8 w-8"
                            src="{{ asset('storage/images/' . $comment->creator_image) }}" />
                    @else
                        <div class="w-8 rounded-full">
                            <img class="rounded-full"
                                src="https://ui-avatars.com/api/?name={{ $comment->creator_name }}&color=7F9CF5&background=EBF4FF" />
                        </div>
                    @endif
                </div>
                <div class="ml-2">
                    <h3 class="font-semibold">{{ $comment->creator_name }}</h3>
                    <div class="flex items-center gap-2 text-sm text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M22 4L12 14.01l-3-3"></path>
                        </svg>
                        <span>
                            @php
                            \Carbon\Carbon::setLocale('id');
                            $human = \Carbon\Carbon::parse($comment->created_at)->diffForHumans();
                            echo $human;
                            @endphp
                        </span>
                    </div>
                    <p>{{ $comment->content }}</p>
                </div>
            </div>
        @endforeach

    </div>
    </div>
</x-noheader-layout>
