<aside class="lg:sticky h-full max-lg:grid grid-cols-2 flex flex-col w-[24rem] max-lg:w-auto gap-2 sm:gap-3 overflow-y-auto top-4">
    {{-- NOTIFIKASI --}}
  <div class="flex flex-col w-full gap-4 py-4 text-white rounded-lg cursor-pointer hide-scroll card group bg-custom-blue">
    <a href="{{ route('notification.index') }}" target="_blank" class="flex items-center gap-3 px-4 text-xl font-semibold">
      <x-lucide-bell class="flex-shrink-0 size-7" />
      <span class="">Notifikasi</span>
    </a>
    <div class="flex flex-col gap-1 px-2">
      @foreach ($notification as $notif)
        <div class="flex w-full items-center gap-3 max-[400px]:gap-2 p-3 max-[400px]:p-2 overflow-hidden text-black bg-white rounded-lg">
          <img class="flex-shrink-0 border rounded-full size-9"
            src="{{ $notif->foto ? asset('storage/images/' . $notif->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($notif->name) . '&color=7F9CF5&background=EBF4FF' }}"
            alt="{{ $notif->name }}">
          <div class="flex flex-col">
            <h1 class="font-semibold line-clamp-1 max-[400px]:text-sm">{{ $notif->name }}</h1>
            <p class="text-sm leading-tight line-clamp-1 max-[400px]:text-xs">
              @if (strpos($notif->message, 'mengomentari') !== false)
                Mengomentari Postingan Anda
              @elseif (strpos($notif->message, 'admin telah membuat postingan baru') !== false)
                Admin telah membuat postingan baru
              @else
                {{ $notif->message }}
              @endif
            </p>
          </div>
        </div>
      @endforeach

    </div>
  </div>
    {{-- OBROLAN --}}
    <div
        class="flex flex-col w-full gap-4 py-4 text-white rounded-lg cursor-pointer hide-scroll card group bg-custom-blue">
        <a href="{{ route('groups.index')}}" target="_blank" class="flex items-center gap-3 px-4 text-xl font-semibold">
            <x-lucide-message-circle class="flex-shrink-0 size-7" />
            <span class="">Obrolan</span>
        </a>
        <div class="z-10 flex flex-col w-full gap-1 px-2">
            @foreach ($groups as $group)
                <div class="flex w-full items-center gap-3 p-3 overflow-hidden text-black bg-white rounded-lg shadow-md">
                    <a href="{{ $group->status == 'Member' || $group->status == 'Admin' ? route('chats.index', [$group->group_id]) : '#' }}"
                        target="_blank" class="flex items-center space-x-3 flex-grow">
                        <img class="flex-shrink-0 border rounded-full w-9 h-9"
                            src="{{ $group->image ? asset('storage/images/' . $group->image) : 'https://ui-avatars.com/api/?name=' . urlencode($group->nama) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="{{ $group->nama }}">
                        <div class="flex flex-col">
                            <h1 class="text-sm font-semibold line-clamp-1">{{ $group->group_name }}</h1>
                            <p class="text-xs leading-tight line-clamp-1">{{ $group->description }}</p>
                            <span class="text-xs leading-tight line-clamp-1">{{ $group->nama }}</span>
                        </div>
                    </a>
                    <div class="flex items-center space-x-2">
                        @if ($group->status == 'Admin')
                            <form action="{{ route('groups.destroy', [$group->group_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300 flex items-center justify-center">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            </form>
                        @endif
                        @if ($group->status != 'Admin')
                            @if ($group->status == 'Pending')
                                <form action="{{ route('groups.cancel', [$group->group_id]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="text-sm bg-red-300 font-semibold px-2.5 py-0.5 rounded-md flex items-center justify-center">
                                        <x-lucide-ban class="w-4 h-4" />
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('groups.leave', [$group->group_id]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                    @if ($group->unread_messages_count > 0)
                        <div class="ml-auto my-auto">
                            <span class="badge badge-warning px-1.5">{{ $group->unread_messages_count }}</span>
                        </div>
                    @endif
                </div>
            @endforeach

            @foreach ($otherGroups as $group)
                <div
                    class="flex w-full items-center max-[400px]:gap-2 gap-3 max-[400px]:p-2 p-3 overflow-hidden text-black bg-white rounded-lg">
                    <img class="flex-shrink-0 border rounded-full size-9"
                        src="{{ $group->nama ? asset('storage/images/' . $group->image) : 'https://ui-avatars.com/api/?nama=' . urlencode($group->nama) . '&color=7F9CF5&background=EBF4FF' }}"
                        alt="{{ $group->nama }}">
                    <div class="flex flex-col">
                        <h1 class="max-[400px]:text-sm font-semibold line-clamp-1">{{ $group->group_name }}</h1>
                        <p class="max-[400px]:text-xs text-sm leading-tight line-clamp-1">
                            {{ $group->description }}
                        </p>
                        <span class="max-[400px]:text-xs text-sm leading-tight line-clamp-1">{{ $group->nama }}</span>
                    </div>
                    <div class="max-[450px]:hidden my-auto ml-auto">
                        <form action="{{ route('groups.join', [$group->id_group]) }}" method="POST">
                            @csrf
                            <button
                                class="text-sm bg-green-300 font-semibold mt-2p-4 p-2 m-4 rounded-md flex gap-1 items-center">
                                <x-lucide-circle-plus class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- NAVIGASI --}}
    <div class="flex flex-col w-full overflow-hidden text-white rounded-lg cursor-pointer card group bg-custom-blue">
        <h1 class="flex items-center gap-3 p-4 text-xl font-semibold">
            <x-lucide-navigation class="flex-shrink-0 size-7" />
            <span class="">Navigasi</span>
        </h1>
        <div class="flex flex-col w-full gap-3 !h-[400px]" id="map"></div>
    </div>
</aside>
