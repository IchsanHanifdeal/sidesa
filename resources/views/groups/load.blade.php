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
