<x-app-layout>
    <!-- Header -->
    <div
        class="fixed top-0 left-0 right-0 bg-[#8ba1bc] text-black w-full shadow-md px-4 py-2 z-10">
        <div class="flex items-center justify-between">
            <a href={{ route('groups.members', [$group->id]) }} class="flex items-center space-x-4">
                <!-- Logo WhatsApp -->
                @if ($group->image)
                    <img src="{{ asset('storage/images/' . $group->image) }}" alt="WhatsApp Logo"
                        class="h-8 w-8 rounded-full">
                @else
                    <div class="h-8 w-8 bg-gray-300 rounded-full"></div>
                @endif

                <!-- Nama Grup -->
                <div>
                    <div class="font-semibold text-lg">
                        {{ $group->group_name }}
                    </div>
                    <div class="text-gray-900 text-sm">{{ $totalGroupMembers }} anggota</div>
                </div>
            </a>

            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                  </svg>

            </a>
        </div>
    </div>

    <!-- Daftar Chat -->
    <div id="chat-content" class="px-4 mx-auto pt-5 overflow-y-auto" style="height: calc(100vh - 80px);">
        @foreach ($messages as $message)
            {{-- other --}}
            @if ($message->is_me == 0)
                @if ($message->attachment)
                    @php $isImage = in_array($message->attachment_type, ['image/jpeg', 'image/png', 'image/gif']); @endphp
                    @if ($isImage)
                        {{-- attachment image --}}
                        <div class="flex items-center mb-4">
                            @if ($message->image)
                                <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                    class="w-10 h-10 rounded-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                    alt="User Image" class="w-10 h-10 rounded-full">
                            @endif

                            <div class="bg-[#81c6d9] rounded-lg py-2 px-4 ml-2">
                                <img src="{{ asset('storage/attachments/' . $message->attachment) }}" alt="Image"
                                    class="w-full h-40 object-cover rounded-lg">
                                <div class="text-sm text-gray-900 font-bold mt-3">
                                    {{ $message->name }}
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- attachment file --}}
                        <div class="flex items-center mb-4">
                            @if ($message->image)
                                <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                    class="w-10 h-10 rounded-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                    alt="User Image" class="w-10 h-10 rounded-full">
                            @endif
                            <div class="bg-[#81c6d9] rounded-lg py-2 px-4 ml-2">
                                <div class="flex flex-col items center space-x-2">
                                    <div>
                                        <div class="text-sm text-gray-900 font-bold">
                                            {{ $message->name }}
                                        </div>
                                        <div class="text-base">{{ $message->message_content }}</div>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('chats.download', ['id' => $message->id]) }}"
                                        class="bg-[#81c6d9] text-black px-2 py-1 rounded-lg">Download File</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- tidak ada attachment --}}
                    <div class="flex items-center mb-4">
                        @if ($message->image)
                            <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                class="w-10 h-10 rounded-full">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                alt="User Image" class="w-10 h-10 rounded-full">
                        @endif
                        <div class="bg-[#81c6d9] rounded-lg py-2 px-4 ml-2">
                            <div class="text-sm text-gray-900 font-bold">
                                {{ $message->name }}
                            </div>
                            <div class="text-base">{{ $message->message_content }}</div>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                @endif
            @else
                {{-- me --}}
                @if ($message->attachment)
                    @php $isImage = in_array($message->attachment_type, ['image/jpeg', 'image/png', 'image/gif']); @endphp
                    @if ($isImage)
                        {{-- attachment image --}}
                        <div class="flex items-center justify-end mb-4">
                            <div class="bg-[#dadada] rounded-lg py-2 px-4 mr-2">
                                <img src="{{ asset('storage/attachments/' . $message->attachment) }}" alt="Image"
                                    class="w-full h-40 object-cover rounded-lg">
                                <div class="text-base mt-3">
                                    {{ $message->message_content }}
                                </div>
                                <p class="text-xs text-right text-gray-500">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                                </p>
                            </div>
                            @if ($message->image)
                                <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                    class="w-10 h-10 rounded-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                    alt="User Image" class="w-10 h-10 rounded-full">
                            @endif
                        </div>
                    @else
                        {{-- attachment file --}}
                        <div class="flex items-center justify-end mb-4">
                            <div class="bg-[#dadada] rounded-lg py-2 px-4 mr-2">
                                <div class="flex flex-col items center space-x-2">
                                    <div>
                                        <div class="text-base">
                                            {{ $message->message_content }}
                                        </div>
                                        <p class="text-xs text-right text-gray-500">
                                            {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('chats.download', ['id' => $message->id]) }}"
                                        class="bg-[#dadada] text-black px-2 py-1 rounded-lg">Download File</a>
                                </div>
                            </div>
                            @if ($message->image)
                                <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                    class="w-10 h-10 rounded-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                    alt="User Image" class="w-10 h-10 rounded-full">
                            @endif
                        </div>
                    @endif
                @else
                    {{-- tidak ada attachment --}}
                    <div class="flex items-center justify-end mb-4">
                        <div class="bg-[#dadada] rounded-lg py-2 px-4 mr-2">
                            <div class="text-base">
                                {{ $message->message_content }}
                            </div>
                            <p class="text-xs text-right text-gray-500">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d F Y') }}
                            </p>
                        </div>
                        @if ($message->image)
                            <img src="{{ asset('storage/images/' . $message->image) }}" alt="User Image"
                                class="w-10 h-10 rounded-full">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $message->name }}&color=7F9CF5&background=EBF4FF"
                                alt="User Image" class="w-10 h-10 rounded-full">
                        @endif
                    </div>
                @endif
            @endif
        @endforeach

        <div id="bottomOfChat" class="pb-12"></div>

    </div>

    <!-- Input Pesan -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-md px-4 py-2">
        <form action="{{ route('chats.post', [
            'id' => $group->id,
        ]) }}" method="POST"
            enctype="multipart/form-data" class="flex items-center space-x-2">
            @csrf
            <input type="text" name="message_content" placeholder="Ketik pesan..."
                class="flex-grow border rounded-lg px-4 py-2 focus:outline-none">
            <!-- Logo Attachment -->
            <label for="attachment" class="cursor-pointer">
                {{-- // attachment svg --}}

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 rotate-12">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                </svg>

            </label>
            <input type="file" id="attachment" name="attachment" class="hidden">
            <button type="submit" id="sendButton"
                class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>

    <script>
        // Scroll ke bawah halaman saat halaman selesai dimuat
        window.onload = function() {
            var chatContainer = document.querySelector('.overflow-y-auto');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        };

        document.getElementById('attachment').addEventListener('change', function() {
            // Mengubah label pada tombol attachment menjadi nama file yang dipilih
            var fileName = this.files[0].name;
            var labelElement = document.querySelector('label[for="attachment"]');
            var ext = fileName.split('.').pop();
            labelElement.textContent = ext;
        });

        document.getElementById('sendButton').addEventListener('click', function() {
            // Mengirimkan form atau melakukan aksi lainnya saat tombol kirim ditekan
            var formElement = document.querySelector('form');
            formElement.submit(); // Ganti dengan aksi yang sesuai dengan kebutuhan Anda
        });

        function scrollToBottom() {
            var element = document.getElementById("bottomOfChat");
            // focus
            element.scrollIntoView();
        }


        // Fungsi untuk memuat konten dari endpoint dan mengganti isi #chat-content
        function loadChatContent() {
            // Lakukan pemanggilan AJAX ke endpoint Anda
            fetch('{{ route('chats.load', ['id' => $group->id]) }}')
                .then(response => response.text())
                .then(html => {
                    // Ubah konten dari #chat-content dengan HTML yang baru
                    document.getElementById('chat-content').innerHTML = html;

                    // Scroll ke paling bawah setelah konten diperbarui
                    // focus to id bottomOfChat
                    scrollToBottom();
                })
                .catch(error => {
                    console.error('Error fetching chat content:', error);
                });
        }

        setInterval(function() {
            loadChatContent(); // Memanggil fungsi loadChatContent setiap interval
            // scrollToBottom(); // Scroll ke paling bawah setelah konten diperbarui
        }, 2000);
    </script>

</x-app-layout>
