<x-app-layout>
  <main class="flex flex-col w-full min-h-screen">
    <div class="flex flex-col m-auto">
      <div class="flex flex-col">
        <h1 class="text-6xl font-extrabold text-center">SIDESA</h1>
        <h1 class="text-2xl font-extrabold text-center text-gray-400 uppercase">Sistem Informasi Desa </h1>
      </div>

      <form method="POST" action="{{ route('login') }}" class="flex flex-col items-center w-full max-w-sm gap-2 mt-10">
        @csrf
        <input type="number" required autofocusS name="no_hp" placeholder="Masukan No HP" class="w-full bg-custom-blue/20 font-bold py-3 text-center rounded-[40px]">
        <input type="password" required name="password" placeholder="Masukan Password" class="w-full bg-custom-blue/20 font-bold py-3 text-center rounded-[40px]">
        <button type="submit"
          class="w-full bg-gradient-to-r from-blue-500 mt-4 to-custom-blue hover:from-custom-blue hover:to-blue-500 text-white font-bold py-3 text-center rounded-[40px]">
          Masuk
        </button>
      </form>
    </div>
  </main>
</x-app-layout>
