<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="flex flex-col justify-evenly min-h-screen">
        @csrf
        <section>
            <h1 class="text-5xl text-center font-extrabold">SIDESA</h1>
            <h1 class="text-sm text-center font-extrabold">Sistem Informasi Desa</h1>
        </section>

        <section>
            <div class="bg-[#23335f] text-black w-full max-w-xs mx-auto rounded-md px-7 py-5">
                <h2 class="text-white text-center font-semibold text-2xl">Log in</h2>
                <div class="space-y-3 mt-7">
                    <input type="text" required name="no_hp" placeholder="No Handphone" class="input bg-[#a6b8c5] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
                    <input type="password" required name="password" placeholder="Kata Sandi" class="input bg-[#a6b8c5] placeholder:text-black input-bordered w-full max-w-xs mx-auto" />
                    <button type="submit" class="px-3 py-2 btn btn-info border-none bg-[#81c7d8] w-full max-w-xs mx-auto">MASUK</button>
                </div>
            </div>
        </section>
    </form>
</x-guest-layout>
