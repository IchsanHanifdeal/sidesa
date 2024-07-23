<x-noheader-layout>
    <div class="px-3 flex gap-2 flex-wrap">
        <div class="flex w-full justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Grup</h2>
            @if (auth()->user()->role == 'Admin')
                <a href="{{ route('groups.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">Buat Grup Baru</a>
            @endif
        </div>

        <div class="w-full grid mt-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @foreach ($groups as $group)
                <div class="bg-white rounded-xl">
                    <a href="
                    {{ $group->status == 'Member' || $group->status == 'Admin' ? route('chats.index', [$group->group_id]) : '#' }}"
                    target="_blank"
                        class="bg-white flex  justify-between text-black rounded-md p-4 transition duration-300 ease-in-out transform hover:-translate-y-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-gray-300 rounded-full">
                                <img src="{{ asset('storage/images/' . $group->image) }}" alt="Group Image"
                                    class="object-cover w-full h-full rounded-full">
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold">{{ $group->group_name }}</div>
                                <div class="text-sm text-gray-500">{{ $group->description }}</div>
                                <div class="indicator-item badge badge-info">{{ $group->nama }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="bg-[#81c6d9] text-white rounded-full w-8 h-8 flex items-center justify-center">
                                {{ $group->unread_messages_count }}
                            </div>
                        </div>
                    </a>

                    @if ($group->status == 'Admin')
                        <form action="{{ route('groups.destroy', [$group->group_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="btn-error btn m-3">
                                Hapus
                            </button>
                        </form>
                    @endif

                    @if ($group->status != 'Admin')
                        @if ($group->status == 'Pending')
                            <form action="{{ route('groups.cancel', [$group->group_id]) }}" method="POST">
                                @csrf
                                <button
                                    class="text-sm bg-red-300 font-semibold mt-2p-4 p-2 m-4 rounded-md flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    Batalkan Permintaan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('groups.leave', [$group->group_id]) }}" method="POST">
                                @csrf
                                <button
                                    class="btn btn-sm btn-error m-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    Tinggalkan Grup
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            @endforeach


            @foreach ($otherGroups as $group)
                <div class="bg-white">
                    <a href="#"
                        class="bg-white flex  justify-between text-black rounded-md p-4 transition duration-300 ease-in-out transform hover:-translate-y-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-gray-300 rounded-full">
                                <img src="{{ asset('storage/images/' . $group->image) }}" alt="Group Image"
                                    class="object-cover w-full h-full rounded-full">
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold">{{ $group->group_name }}</div>
                                <div class="text-sm text-gray-500">{{ $group->description }}</div>
                                <div class="indicator-item badge badge-info">{{ $group->nama }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="bg-[#81c6d9] text-white rounded-full w-8 h-8 flex items-center justify-center">
                                -
                            </div>
                        </div>
                    </a>

                    <form action="{{ route('groups.join', [$group->id_group]) }}" method="POST">
                        @csrf
                        <button
                            class="text-sm bg-green-300 font-semibold mt-2p-4 p-2 m-4 rounded-md flex gap-1 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Gabung
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-noheader-layout>
