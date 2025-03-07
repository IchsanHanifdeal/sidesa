<x-noheader-layout>
    <div class="px-4 max-w-7xl mx-auto">
        <div class="flex w-full justify-between items-center">
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-md"> < </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Pengguna</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Card Anggota Desa -->
            @foreach ($users as $user)
                <div class="card w-full bg-black shadow-2xl mb-6">
                    <div class="card-body items-center text-center">
                        <div class="avatar mb-4">
                            <div class="w-24 rounded-full">
                                @if ($user->image)
                                    <img src="{{ asset('storage/images/' . $user->image) }}"
                                        alt="{{ $user->name }}" />
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF"
                                        alt="{{ $user->name }}" />
                                @endif
                            </div>
                        </div>
                        <h2 class="card-title text-lg">{{ $user->name }}</h2>

                        <table class="table w-full">
                            <tbody>
                                <tr>
                                    <td><span class="text-sm text-white">NIK</span></td>
                                    <td><span class="text-sm text-white">{{ $user->nik }}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text-sm text-white">No. HP</span></td>
                                    <td><span class="text-sm text-white">{{ $user->no_hp }}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="text-sm text-white">Alamat</span></td>
                                    <td><span class="text-sm text-white">{{ $user->alamat }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="map_{{ $user->id }}" style="height: 400px; width: 100%;"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (Auth::user()->role == 'Admin')
                            <div class="card-actions mt-4">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-error">Hapus</button>
                                </form>
                                <form action="{{ route('users.confirm', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="btn {{ $user->is_confirmed ? 'btn-warning' : 'btn-success' }}">
                                        {{ $user->is_confirmed ? 'Batalkan Konfirmasi' : 'Konfirmasi' }}</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <script>
                    var map = L.map('map_{{ $user->id }}', {
                        layers: L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                        })
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    var currentUser = {
                        lat: parseFloat('{{ $user->lat }}'),
                        long: parseFloat('{{ $user->long }}'),
                        name: '{{ $user->name }}'
                    };

                    map.setView([currentUser.lat, currentUser.long], 17);

                    L.marker([currentUser.lat, currentUser.long]).addTo(map)
                        .bindPopup('<b> Rumah ' + currentUser.name + '</b>')
                        .openPopup();
                </script>
            @endforeach
        </div>
    </div>
</x-noheader-layout>
