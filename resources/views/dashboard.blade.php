<x-app-layout>
    @if (auth()->user()->is_confirmed)
        <x-slot name="header">
        </x-slot>
        <div class="mt-12"></div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-5">
            <!-- Kolom pertama -->
            <div class="bg-transparent shadow-lg shadow-slate-300 p-5 rounded-md col-span-1 md:col-span-3 text-center">
                <iframe src="{{ route('groups.index') }}" class="w-full h-[400px] md:h-[600px]"></iframe>
            </div>
            
            <!-- Kolom kedua -->
            <div class="bg-gray-400 text-center rounded-md col-span-1 md:col-span-6">
                <iframe src="{{ route('posts.index') }}" class="w-full h-[600px] md:h-[1000px]"></iframe>
            </div>
            
            <!-- Kolom ketiga -->
            <div class="bg-transparent flex flex-col gap-5 shadow-lg shadow-slate-300 w-full mx-auto rounded-md col-span-1 md:col-span-3 text-center">
                <div class="w-full max-w-xs mx-auto flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center shadow-lg">
                    <div class="block rounded-t overflow-hidden text-center">
                        <div class="bg-blue text-white bg-info py-1">
                            @php
                                $day = now()->locale('id')->dayName;
                                $date = now()->format('d');
                                $clock = now()->format('H:i');
                                $month = now()->format('M');
                            @endphp
                            {{ $month }}
                        </div>
                        <div class="pt-1 border-l border-r border-white bg-white">
                            <span class="text-5xl font-bold leading-tight">
                                {{ $date }}
                            </span>
                        </div>
                        <div class="border-l border-r border-b rounded-b-lg text-center border-white bg-white -pt-2 -mb-1">
                            <span class="text-sm">
                                {{ $day }}
                            </span>
                        </div>
                        <div class="pb-2 border-l border-r border-b rounded-b-lg text-center border-white bg-white">
                            <span class="text-xs leading-normal">
                                {{ $clock }}
                            </span>
                        </div>
                    </div>
                </div>
                <iframe src="{{ route('notification.index') }}" class="w-full h-[200px] md:h-[300px]"></iframe>
                <iframe src="{{ route('users.index') }}" class="w-full h-[600px] md:h-[1000px]"></iframe>
                <div class="rounded-md mx-3 mb-12" id="map" style="height: 300px;"></div>
            </div>
        </div>

        <script>
            var map = L.map('map', {
                layers: L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                })
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var usersData = {!! json_encode($anggotaDesa) !!};

            var centerUser = usersData[0];
            map.setView([parseFloat(centerUser.lat), parseFloat(centerUser.long)], 17);

            usersData.forEach(function(user) {
                var lat = parseFloat(user.lat);
                var lng = parseFloat(user.long);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('<b> Rumah ' + user.name + '</b>')
                    .openPopup();
            });
        </script>
    @else
        <div class="min-h-screen mx-auto w-full">
            <div class="flex items-center mt-12 justify-center">
                <h1 class="text-info font-bold text-xl text-center">
                    Menunggu konfirmasi admin
                </h1>
            </div>
        </div>
    @endif
</x-app-layout>