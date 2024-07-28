<style>
    .fill-red {
        fill: red;
    }

    .fill-white {
        fill: white;
    }

    .stroke-black {
        stroke: black;
    }
</style>
<div class="flex flex-col max-sm:mt-4 max-lg:w-full w-[36rem] gap-4 overflow-y-auto">
    <h2 class="pb-4 text-2xl font-bold border-b border-black">Ada Apa Hari Ini?</h2>
    <form method="post" enctype="multipart/form-data" action="{{ route('posts.store') }}" class="w-full">
        @csrf
        <div class="flex gap-4 p-3 bg-white rounded-lg">
            <input type="hidden" name="idGroup" value="{{ $idGroup }}">
            @if (Auth::user()->image)
                <img class="flex-shrink-0 border rounded-full size-11"
                    src="{{ asset('storage/images/' . Auth::user()->image) }}" alt="">
            @else
                <img class="flex-shrink-0 border rounded-full size-11"
                    src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF">
            @endif
            <div class="flex flex-wrap w-full">
                <textarea class="w-full p-2 px-4 text-black bg-gray-50 rounded- placeholder:text-[15px] rounded-lg" name="content"
                    placeholder="Apa yang anda pikirkan?"></textarea>
                <img id="preview" class="flex-shrink-0 mt-3 border rounded-lg w-full max-h-[300px] object-cover"
                    src="" alt="">
                <div class="flex items-center justify-between w-full mt-3">
                    <div class="flex items-center gap-4">
                        <button type="button" class="flex items-center gap-4">
                            <input type="file" accept="image/*" id="foto" class="hidden" name="image">
                            <label for="foto" class="flex items-center gap-1 cursor-pointer">
                                <x-lucide-image class="flex-shrink-0 size-5" />
                                <h1>Foto</h1>
                            </label>
                        </button>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1">
                                <input type="checkbox" id="for_sale" checked="checked"
                                    class="checkbox checkbox-secondary checkbox-xs" name="for_sale" />
                                <label for="for_sale">Dijual</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="flex gap-2 btn btn-xs">
                        <x-lucide-send-horizontal class="flex-shrink-0 size-4" />
                        Kirim
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="flex flex-col w-full gap-2 sm:gap-3">
        @foreach ($posts as $post)
            <div class="flex flex-col w-full gap-3 p-3 text-black bg-white rounded-lg">
                <div class="flex gap-3">
                    @if ($post->creator_image)
                        <img class="flex-shrink-0 border rounded-full size-9"
                            src="{{ asset('storage/images/' . $post->creator_image) }}" alt="">
                    @else
                        <img class="flex-shrink-0 border rounded-full size-9"
                            src="https://ui-avatars.com/api/?name={{ $post->creator_name }}&color=7F9CF5&background=EBF4FF" />
                    @endif
                    <div class="flex flex-col -space-y-1 text-sm">
                        <h1 class="font-semibold">{{ $post->creator_name }}</h1>
                        <p class="text-gray-500">
                            @php
                                \Carbon\Carbon::setLocale('id');
                                $human = \Carbon\Carbon::parse($post->updated_at)->diffForHumans();
                                echo $human;
                            @endphp
                        </p>
                    </div>
                </div>
                @if ($post->photo)
                    <img class="flex-shrink-0 border rounded-lg w-full max-h-[300px] object-cover"
                        src="{{ asset('storage/images/' . $post->photo) }}" alt="">
                @endif
                <a class="text-[15px] leading-tight">
                    {{ $post->content }}
                </a>
                <div class="flex justify-between w-full mt-2">
                    <div class="flex gap-3">
                        <button
                            class="like-button {{ $post->is_liked ? 'text-red-500' : 'text-black' }} flex items-center gap-2 text-[15px] cursor-pointer"
                            data-post-id="{{ $post->id }}">
                            <x-lucide-heart
                                class="flex-shrink-0 size-5 {{ $post->is_liked ? 'fill-red' : 'fill-white' }} {{ $post->is_liked ? '' : 'stroke-black' }}" />
                            <span class="like-count">{{ $post->like_count }}</span>
                        </button>
                        <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 text-[15px] cursor-pointer">
                            <x-lucide-message-square class="flex-shrink-0 size-5" />
                            {{ $post->comment_count }}
                        </a>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if ($post->creator_id == Auth::id())
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                    class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300 flex items-center justify-center">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            </form>
                        @endif
                        @if ($post->for_sale)
                            @php
                                $creator = App\Models\User::find($post->creator_id);
                                $customMessage =
                                    'Halo, saya tertarik dengan ' .
                                    $post->content .
                                    '. Bolehkah saya bertanya lebih lanjut?';
                                $msg = "https://wa.me/{$creator->no_hp}?text={$customMessage}";
                            @endphp
                            <a href="{{ $msg }}" target="_blank"
                                class="text-center text-white bg-green-500 btn btn-xs">Hubungi Penjual</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fotoInput = document.getElementById('foto');
        const previewImage = document.getElementById('preview');
        previewImage.style.display = 'none';

        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const blob = URL.createObjectURL(file);
                previewImage.style.display = 'block';
                previewImage.src = blob;
            }
        });

        previewImage.addEventListener('click', function() {
            previewImage.style.display = 'none';
            previewImage.src = '';
            fotoInput.value = '';
        });
    });
</script>

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

                    const heartIcon = button.querySelector('.x-lucide-heart');
                    if (data.liked) {
                        button.classList.add('text-red-500');
                        button.classList.remove('text-black');
                        heartIcon.classList.add('fill-red');
                        heartIcon.classList.remove('fill-white', 'stroke-black');
                    } else {
                        button.classList.remove('text-red-500');
                        button.classList.add('text-black');
                        heartIcon.classList.add('fill-white', 'stroke-black');
                        heartIcon.classList.remove('fill-red');
                    }
                }
            });
        });
    });
</script>
