<div class="flex flex-col max-lg:w-full w-[36rem] gap-4 overflow-y-auto">
  <h2 class="pb-4 text-2xl font-bold border-b border-black">Ada Apa Hari Ini?</h2>
  <div class="flex gap-4 p-3 bg-white rounded-lg">
    <img class="flex-shrink-0 border rounded-full size-11" src="https://avatars.githubusercontent.com/u/93970726?v=4" alt="">
    <div class="flex flex-wrap w-full">
      <textarea class="w-full p-2 px-4 text-black bg-gray-50 rounded- placeholder:text-[15px] rounded-lg" placeholder="Apa yang anda pikirkan?"></textarea>
      <div class="flex items-center justify-between w-full mt-3">
        <div class="flex items-center gap-4">
          <button class="flex items-center gap-4">
            <input type="file" accept="image/*" id="foto" class="hidden">
            <label for="foto" class="flex items-center gap-1">
              <x-lucide-image class="flex-shrink-0 size-5" />
              <h1>Foto</h1>
            </label>
          </button>
          <button class="flex items-center gap-4">
            <div class="flex items-center gap-1">
              <input type="checkbox" id="dijual" checked="checked" class="checkbox checkbox-secondary checkbox-xs" />
              <label for="dijual"dijual>Dijual</label>
            </div>
          </button>
        </div>
        <button class="flex gap-2 btn btn-xs">
          <x-lucide-send-horizontal class="flex-shrink-0 size-4" />
          Kirim
        </button>
      </div>
    </div>
  </div>
  <div class="flex flex-col w-full gap-3">
    @foreach (new SplFixedArray(6) as $item)
      <div class="flex flex-col w-full gap-3 p-3 text-black bg-white rounded-lg">
        <div class="flex gap-3">
          <img class="flex-shrink-0 border rounded-full size-9" src="https://avatars.githubusercontent.com/u/93970726?v=4" alt="">
          <div class="flex flex-col -space-y-1 text-sm">
            <h1 class="font-semibold">Kejaa</h1>
            <p class="text-gray-500">3 menit</p>
          </div>
        </div>
        <img class="flex-shrink-0 border rounded-lg w-full max-h-[300px] object-cover" src="/rumah.jpeg" alt="">
        <p class="text-[15px] leading-tight">
          Consectetur Lorem eiusmod Lorem eiusmod laborum. Velit veniam do adipisicing elit adipisicing nostrud magna amet.
        </p>
        <div class="flex justify-between w-full mt-2">
          <div class="flex gap-3">
            <h1 class="flex items-center gap-2 text-[15px]">
              <x-lucide-heart class="flex-shrink-0 size-5" />
              234
            </h1>
            <h1 class="flex items-center gap-2 text-[15px]">
              <x-lucide-message-square class="flex-shrink-0 size-5" />
              100
            </h1>
          </div>
          <button class="text-center text-white bg-green-500 btn btn-xs">WhatsApp</button>
        </div>
      </div>
    @endforeach
  </div>
</div>