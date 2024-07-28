<x-app-layout>
  <div class="flex flex-col min-h-screen">
    <form method="POST" action="{{ route('register') }}" class="flex flex-col w-full max-w-md gap-4 p-4 mx-auto">
      @csrf
      <h1 class="p-5 text-3xl font-extrabold text-center uppercase">Daftar Desa</h1>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="nama">Nama Desa<span class="text-red-500">*</span></label>
        <input type="text" required name="nama" autofocus id="nama" placeholder="Masukkan Nama Desa" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="kode_pos">Kode Pos<span class="text-red-500">*</span></label>
        <input type="number" required name="kode_pos" id="kode_pos" placeholder="Masukkan Kode Pos" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="alamat">Alamat<span class="text-red-500">*</span></label>
        <input type="text" required name="alamat" id="alamat" placeholder="Masukkan Alamat" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="name">Nama Nama Pengguna<span class="text-red-500">*</span></label>
        <input type="text" required name="name" id="name" placeholder="Masukkan Nama Pengguna" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="no_hp">Nomor HP<span class="text-red-500">*</span></label>
        <input type="number" required name="no_hp" id="no_hp" placeholder="Masukkan Nomor HP" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="password">Password<span class="text-red-500">*</span></label>
        <input type="password" required name="password" id="password" placeholder="Masukkan Password" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-600" for="password_confirmation">Konfirmasi Password<span class="text-red-500">*</span></label>
        <input type="password" required name="password_confirmation" id="password_confirmation" placeholder="Masukkan Lagi Password" class="input bg-[#c2d7ec] input-bordered w-full" />
      </div>

      <button type="submit" class="w-full px-3 py-2 mx-auto text-white border-none btn bg-custom-blue">DAFTAR</button>
    </form>
  </div>
</x-app-layout>
