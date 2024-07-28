<x-app-layout>
  @if (auth()->user()->is_confirmed)
    <div class="flex flex-col w-full max-w-full min-h-screen p-3 mx-auto border-black lg:p-5">
      @include('dashboard.navbar')
      @include('dashboard.layouts', ['users' => $anggotaDesa])
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
    <div class="w-full min-h-screen mx-auto">
      <div class="flex items-center justify-center mt-12">
        <h1 class="text-xl font-bold text-center text-info">
          Menunggu konfirmasi admin
        </h1>
      </div>
    </div>
  @endif
</x-app-layout>
