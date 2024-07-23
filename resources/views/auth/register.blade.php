<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col justify-evenly h-screen">
        @csrf
        <section>
            <h1 class="text-3xl text-center font-extrabold">Daftar DESA</h1>
        </section>

        <section class="mt-5 flex flex-col gap-4">
            <input type="text" required name="nama" placeholder="Nama Desa" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="text" required name="kode_pos" placeholder="Kode Pos" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="text" required name="alamat" placeholder="Alamat Desa" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="text" required name="name" placeholder="Nama Pengguna" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="text" required name="no_hp" placeholder="No Handphone" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="password" required name="password" placeholder="Kata Sandi" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
            <input type="password" required name="password_confirmation" placeholder="Konfirmasi Kata Sandi" class="input bg-[#7f9ab6] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
        </section>

        <section class="mt-5 flex justify-center">
            <button type="submit" class="px-3 py-2 btn border-none bg-[#81c7d8] w-full max-w-xs mx-auto">DAFTAR</button>
        </section>

    </form>
</x-guest-layout>
