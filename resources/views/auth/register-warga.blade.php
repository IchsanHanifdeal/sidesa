<x-guest-layout>
    <form method="POST"
    enctype="multipart/form-data"
    action="{{ route('register-warga.store') }}" class="flex flex-col justify-evenly">
        @csrf
        <section>
            <h1 class="text-3xl font-extrabold text-center">Daftar Akun</h1>
        </section>

        <section class="flex flex-col items-center gap-4 mt-5">
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="name">Nama Pengguna<span class="text-red-500">*</span></label>
                <input type="text" required name="name" autofocus id="name" placeholder="Masukkan Nama Pengguna"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="nik">NIK<span class="text-red-500">*</span></label>
                <input type="number" required name="nik" 
                maxlength="16"
                minlength="16"
                id="nik" placeholder="Masukkan NIK"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="alamat">Alamat<span class="text-red-500">*</span></label>
                <input type="text" required name="alamat" id="alamat" placeholder="Masukkan Alamat"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="no_hp">No Handphone<span class="text-red-500">*</span></label>
                <input type="text" required name="no_hp" id="no_hp" placeholder="Masukkan No Handphone"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="id_desa">Pilih Desa<span class="text-red-500">*</span></label>
                <select name="id_desa" id="id_desa" required class="input bg-[#7f9ab6] placeholder:text-black text-black input-bordered w-full">
                    <option value="">Pilih Desa</option>
                    @foreach ($daftarDesa as $desa)
                        <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="password">Kata Sandi<span class="text-red-500">*</span></label>
                <input type="password" required name="password" id="password" placeholder="Masukkan Kata Sandi"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="password_confirmation">Konfirmasi Kata Sandi<span class="text-red-500">*</span></label>
                <input type="password" required name="password_confirmation" id="password_confirmation" placeholder="Masukkan  Konfirmasi Kata Sandi"
                       class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full" />
            </div>
        
            <div class="w-full max-w-sm">
                <label class="block mb-1 text-white" for="fileInput">Upload Gambar<span class="text-red-500">*</span></label>
                <input type="file" name="image" class="file-input w-full" />
            </div>
        </section>
        

        <section class="flex justify-center mt-5">
            <button type="submit"
                class="px-3 py-2 btn btn-info border-none w-full max-w-sm mx-auto">DAFTAR</button>
        </section>

    </form>
</x-guest-layout>
