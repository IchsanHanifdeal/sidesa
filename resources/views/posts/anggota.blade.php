<x-app-layout>
    <div class="py-5 px-1 flex gap-2 flex-wrap">
        <div class="max-w-md mx-auto w-full text-black p-5 rounded-xl shadow-md overflow-hidden md:max-w-2xl">
            <div class="overflow-x-auto">
                <table class="table text-black">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th class="text-black">No</th>
                            <th class="text-black">Nama</th>
                            <th class="text-black">Status</th>
                            <th class="text-black"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotaGrups as $anggota)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anggota->name }}</td>
                                <td>{{ $anggota->status }}</td>
                                <td>
                                    @if (!$anggota->isMe && $isAdminGroup)
                                        @if ($anggota->status == 'Accepted')
                                            <form action="{{ route('grups.anggota.destroy', [$grup, $anggota->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error">
                                                    Keluarkan
                                                </button>
                                            </form>
                                        @elseif ($anggota->status == 'Pending')
                                            <form action="{{ route('grups.anggota.accept', [$grup, $anggota->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Terima
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
