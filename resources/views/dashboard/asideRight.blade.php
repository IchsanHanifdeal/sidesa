@php
  $day = now()->locale('id')->dayName;
  $date = now()->format('d');
  $clock = now()->format('H:i');
  $month = now()->format('M');
@endphp

<aside class="lg:sticky max-lg:grid grid-cols-2 max-lg:w-full flex flex-col w-[20rem] h-fit gap-2 sm:gap-3 overflow-y-auto top-4">
  {{-- KALENDER --}}
  <div class="flex flex-col flex-shrink-0 w-auto overflow-hidden rounded-lg cursor-pointer group">
    <div class="flex justify-between px-8 bg-red-500 h-9">
      <div class="w-5 h-full bg-yellow-400 rounded-sm"></div>
      <div class="w-5 h-full bg-yellow-400 rounded-sm"></div>
    </div>
    <div class="flex bg-white h-28 max-lg:h-full">
      <h1 class="m-auto text-4xl font-bold text-center">
        {{ $date }} {{ $month }}
        <p class="text-base font-normal">{{ $day }} - {{ $clock }}</p>
      </h1>
    </div>
  </div>
  {{-- NOTIFIKASI --}}
  <div class="flex flex-col w-full gap-4 py-4 text-white rounded-lg cursor-pointer hide-scroll card group bg-custom-blue">
    <h1 class="flex items-center gap-3 px-4 text-xl font-semibold">
      <x-lucide-bell class="flex-shrink-0 size-7" />
      <span class="">Notifikasi</span>
    </h1>
    <div class="flex flex-col gap-1 px-2">
      @foreach ([...$users, ...$users, ...$users, ...$users] as $user)
        <div class="flex w-full items-center max-[400px]:gap-2 gap-3 max-[400px]:p-2 p-3 overflow-hidden text-black bg-white rounded-lg">
          <img class="flex-shrink-0 border rounded-full size-9"
            src="{{ $user->image ? asset('storage/images/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
            alt="{{ $user->name }}">
          <div class="flex flex-col">
            <h1 class="max-[400px]:text-sm font-semibold line-clamp-1">{{ $user->name }}</h1>
            <p class="max-[400px]:text-xs text-sm leading-tight line-clamp-1">
              Membalas komentar obrolan
            </p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  {{-- ANGGOTA --}}
  <div class="flex flex-col w-full p-4 text-white rounded-lg cursor-pointer hide-scroll card group bg-custom-blue">
    <h1 class="flex items-center gap-3 text-xl font-semibold">
      <x-lucide-users-round class="flex-shrink-0 size-7" />
      <span class="">Anggota</span>
    </h1>
    <div class="flex flex-wrap mt-4 overflow-y-auto avatar-group hide-scroll">
      @foreach ($users as $user)
        <div class='cursor-pointer avatar'>
          <div class="size-7 hover:scale-125">
            <img class="flex-shrink-0 border rounded-full"
              src="{{ $user->image ? asset('storage/images/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
              alt="{{ $user->name }}">
          </div>
        </div>
      @endforeach
    </div>
  </div>
  {{-- PENGUMUMAN --}}
  <div class="flex flex-col w-full overflow-hidden text-white rounded-lg cursor-pointer card group bg-custom-blue">
    <h1 class="flex items-center gap-3 p-4 text-xl font-semibold">
      <x-lucide-info class="flex-shrink-0 size-7" />
      <span class="">Pengumuman</span>
    </h1>
    <div class="flex flex-col w-full gap-3 !h-full">
      <img src="/pengumuman.webp" alt="">
    </div>
  </div>
</aside>
