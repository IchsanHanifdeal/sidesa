<x-app-layout>
    @include('dashboard.navbar')

    <!-- Hero Section -->
    <section class="hero bg-cover bg-center h-[60vh] flex items-center justify-center relative"
        style="background-image: url('{{ $galeri->isNotEmpty() ? asset('storage/images/' . $galeri->first()->gambar) : asset('/logo.png') }}');">
        <div class="absolute inset-0 bg-gray-900 opacity-80"></div>
        <div class="relative z-10 text-center text-white px-6">
            <h1 class="text-5xl font-bold mb-4 drop-shadow-md">Selamat Datang di Desa Rimba Makmur</h1>
            <p class="text-lg font-medium drop-shadow-md">
                Desa kecil yang penuh keindahan di Provinsi Riau. Jelajahi keindahan alam dan budayanya.
            </p>
        </div>
    </section>

    <!-- Main Layout -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            <!-- Tentang Desa -->
            <section id="tentang-desa" class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Tentang Desa Rimba Makmur</h2>
                <p class="text-lg leading-relaxed text-gray-600 text-center max-w-3xl mx-auto">
                    Desa Rimba Makmur terletak di Provinsi Riau, Indonesia. Desa ini dikenal dengan keindahan alamnya,
                    dikelilingi oleh hutan yang subur dan udara yang segar. Rimba Makmur adalah tempat di mana tradisi
                    dan modernitas bertemu, menciptakan harmoni yang unik bagi penduduk dan pengunjungnya. Kehidupan
                    masyarakat desa ini sangat erat dengan alam, menjadikannya destinasi menarik untuk pecinta wisata
                    budaya dan alam.
                </p>
            </section>

            <!-- Tentang Aplikasi -->
            <section id="tentang-aplikasi" class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Tentang Aplikasi Sidesa</h2>
                <p class="text-lg leading-relaxed text-gray-600 text-center max-w-3xl mx-auto">
                    Aplikasi Sidesa (Sistem Informasi Desa) dikembangkan oleh Desa Rimba Makmur untuk mempermudah
                    masyarakat dalam mengakses informasi terkait dengan desa, mulai dari berita terkini, jadwal
                    kegiatan, hingga informasi kontak dan galeri desa. Aplikasi ini bertujuan untuk mempercepat
                    proses pelayanan dan meningkatkan transparansi informasi bagi warga desa, serta mempromosikan
                    potensi alam dan budaya Desa Rimba Makmur ke dunia luar.
                </p>
                <p class="text-lg leading-relaxed text-gray-600 text-center mt-4">
                    Dengan Sidesa, kami berharap dapat memperkuat komunikasi antara pemerintah desa dan masyarakat,
                    serta memperkenalkan Desa Rimba Makmur sebagai destinasi wisata yang menarik di Provinsi Riau.
                </p>
            </section>

            <!-- Galeri -->
            <section id="galeri-desa" class="bg-gray-100 p-8 rounded-lg shadow-lg">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Galeri Desa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($galeri as $item)
                        <div class="overflow-hidden rounded-lg shadow-lg bg-white group">
                            <img src="{{ asset('storage/images/' . $item->gambar) }}" alt="Gambar Desa"
                                class="transition-transform duration-300 group-hover:scale-105 rounded-t-lg" />
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-lg font-semibold text-gray-500">Tidak ada galeri tersedia</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Informasi Kontak -->
            <section id="kontak" class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-4xl font-bold text-center text-gray-800 mb-6">Informasi Kontak</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <p class="text-lg font-medium">
                            Untuk informasi lebih lanjut tentang Desa Rimba Makmur, hubungi kami melalui:
                        </p>
                        <div class="space-y-3">
                            <p class="flex items-center gap-2">
                                <x-lucide-map-pin class="w-5 h-5 text-teal-500" />
                                Alamat: Desa Rimba Makmur, Kabupaten Riau, Indonesia
                            </p>
                            <p class="flex items-center gap-2">
                                <x-lucide-mail class="w-5 h-5 text-teal-500" />
                                Email: <a href="mailto:info@rimbamakmur.id" class="text-teal-600 hover:underline">
                                    info@rimbamakmur.id
                                </a>
                            </p>
                            <p class="flex items-center gap-2">
                                <x-lucide-phone class="w-5 h-5 text-teal-500" />
                                Telepon: +62 812-3456-7890
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <p class="text-lg font-medium mb-4">
                            Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Tombol Kembali -->
    <div class="fixed bottom-5 right-5">
        <a href="/dashboard"
            class="inline-flex items-center px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-full shadow hover:bg-teal-600 transition">
            <x-lucide-arrow-left class="w-4 h-4 mr-2" />
            Kembali
        </a>
    </div>
</x-app-layout>
