<aside class="lg:sticky h-full max-lg:grid grid-cols-2 flex flex-col w-[24rem] max-lg:w-auto gap-2 sm:gap-3 overflow-y-auto top-4">
  {{-- OBROLAN --}}
  <div class="flex flex-col w-full gap-4 py-4 text-white rounded-lg cursor-pointer hide-scroll card group bg-custom-blue">
    <h1 class="flex items-center gap-3 px-4 text-xl font-semibold">
      <x-lucide-message-circle class="flex-shrink-0 size-7" />
      <span class="">Obrolan</span>
    </h1>
    <div class="z-10 flex flex-col w-full gap-1 px-2">
      @foreach ([...$users, ...$users, ...$users, ...$users] as $user)
        <div class="flex w-full items-center max-[400px]:gap-2 gap-3 max-[400px]:p-2 p-3 overflow-hidden text-black bg-white rounded-lg">
          <img class="flex-shrink-0 border rounded-full size-9"
            src="{{ $user->image ? asset('storage/images/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
            alt="{{ $user->name }}">
          <div class="flex flex-col">
            <h1 class="max-[400px]:text-sm font-semibold line-clamp-1">{{ $user->name }}</h1>
            <p class="max-[400px]:text-xs text-sm leading-tight line-clamp-1">
              Quis labore reprehenderit cillum qui incididunt.
            </p>  
          </div>
          <div class="max-[450px]:hidden my-auto ml-auto">
            <span class="badge badge-warning px-1.5">1</span>
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
