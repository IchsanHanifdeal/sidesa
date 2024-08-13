<x-noheader-layout>
    <div class="px-3 flex gap-2 flex-wrap">
        <div class="flex w-full justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Galeri</h2>
            @if (auth()->user()->role == 'Admin')
                <a href="{{ route('galeri.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-md">Tambahkan Foto
                    Baru</a>
            @endif
        </div>
    </div>
    <div class="px-4 py-8 flex flex-wrap gap-6 justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($galeri as $gal => $item)
                <div
                    class="relative group bg-base-100 w-full sm:w-80 md:w-96 lg:w-80 shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <figure class="relative h-64">
                        <img src="{{ asset('storage/images/' . $item->gambar) }}" alt="{{ $item->keterangan }}"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 p-4">
                            <div class="text-center text-white">
                                <p class="text-lg font-semibold mb-2 capitalize">{{ $item->keterangan }}</p>
                                <p class="text-sm">{{ $item->tanggal_upload }}</p>
                            </div>
                            @if (Auth::user()->role === 'Admin')
                                <div class="absolute top-4 right-4">
                                    <form action="{{ route('galeri.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-2 py-1 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </figure>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-lg font-semibold">Tidak ada galeri tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</x-noheader-layout>
