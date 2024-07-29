<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <form method="POST" enctype="multipart/form-data" action="{{ route('register-warga.store') }}"
            class="flex flex-col w-full max-w-md gap-4 p-4 mx-auto">
            @csrf
            <h1 class="p-5 text-3xl font-extrabold text-center uppercase">Daftar Akun</h1>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="name">Nama Pengguna<span
                        class="text-red-500">*</span></label>
                <input type="text" required name="name" autofocus id="name"
                    placeholder="Masukkan Nama Pengguna" class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="nik">
                    NIK<span class="text-red-500">*</span>
                </label>
                <input type="text" required name="nik" maxlength="16" minlength="16" id="nik"
                    placeholder="Masukkan NIK"
                    class="input bg-[#c2d7ec] input-bordered w-full 
                  @error('nik') border-red-500 @enderror" />
                @error('nik')
                    <div class="text-red-500 mt-1 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="alamat">Alamat<span
                        class="text-red-500">*</span></label>
                <input type="text" required name="alamat" id="alamat" placeholder="Masukkan Alamat"
                    class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="no_hp">No Handphone<span
                        class="text-red-500">*</span></label>
                <input type="text" required name="no_hp" id="no_hp" placeholder="Masukkan No Handphone"
                    class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="id_desa">Pilih Desa<span
                        class="text-red-500">*</span></label>
                <select name="id_desa" id="id_desa" required
                    class="input bg-[#c2d7ec] text-black input-bordered w-full">
                    <option value="">Pilih Desa</option>
                    @foreach ($daftarDesa as $desa)
                        <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="password">Kata Sandi<span
                        class="text-red-500">*</span></label>
                <input type="password" required name="password" id="password" placeholder="Masukkan Kata Sandi"
                    class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="password_confirmation">Konfirmasi Kata
                    Sandi<span class="text-red-500">*</span></label>
                <input type="password" required name="password_confirmation" id="password_confirmation"
                    placeholder="Masukkan  Konfirmasi Kata Sandi" class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-600" for="fileInput">Upload Gambar<span
                        class="text-red-500">*</span></label>
                <input type="file" name="image" class="w-full file-input" id="foto" />
                <img id="preview" class="flex-shrink-0 mt-3 border rounded-lg w-full max-h-[300px] object-cover"
                    src="" alt="">
            </div>

            <div>
                <input type="hidden" required name="latitude" id="latitude" placeholder=""
                    class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>

            <div>
                <input type="hidden" required name="longitude" id="longitude" placeholder=""
                    class="input bg-[#c2d7ec] input-bordered w-full" />
            </div>


            <button type="submit"
                class="w-full px-3 py-2 mx-auto text-white border-none btn bg-custom-blue">DAFTAR</button>
        </form>
    </div>
    <script>
        window.addEventListener('load', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fotoInput = document.getElementById('foto');
            const previewImage = document.getElementById('preview');
            previewImage.style.display = 'none';

            fotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const blob = URL.createObjectURL(file);
                    previewImage.style.display = 'block';
                    previewImage.src = blob;
                }
            });

            previewImage.addEventListener('click', function() {
                previewImage.style.display = 'none';
                previewImage.src = '';
                fotoInput.value = '';
            });
        });
    </script>
</x-app-layout>
