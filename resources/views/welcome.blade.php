<x-app-layout>
  <main class="flex flex-col w-full min-h-screen">
    <div class="flex flex-col m-auto">
      <div class="flex flex-col">
        <h1 class="text-6xl font-extrabold text-center">SIDESA</h1>
        <h1 class="text-2xl font-extrabold text-center text-gray-400 uppercase">Sistem Informasi Desa </h1>
      </div>

      <div class="flex flex-col items-center w-full max-w-sm gap-2 mt-10">
        <a href="{{ route('register') }}"
          class="w-full bg-gradient-to-r from-blue-500 to-custom-blue hover:from-custom-blue hover:to-blue-500 text-white font-bold py-3 text-center rounded-[40px]">
          Daftar DESA
        </a>
        <a href="{{ route('register-warga') }}"
          class="w-full bg-gradient-to-r from-blue-500 to-custom-blue hover:from-custom-blue hover:to-blue-500 text-white font-bold py-3 text-center rounded-[40px]">
          Daftar Akun
        </a>
        <a href="{{ route('login') }}"
          class="w-full bg-gradient-to-r from-blue-500 to-custom-blue hover:from-custom-blue hover:to-blue-500 text-white font-bold py-3 text-center rounded-[40px]">
          Masuk
        </a>
      </div>
    </div>
  </main>
</x-app-layout>
