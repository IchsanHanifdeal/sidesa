<nav class="flex justify-between items-center w-full bg-white shadow-md px-4 py-3">
    <!-- Logo dan Nama Desa -->
    <label for="desa_modal" class="flex items-center gap-3 cursor-pointer btn btn-ghost capitalize">
        <img src="/logo.png" alt="Logo Desa" class="w-10 h-10" />
        <h1 class="text-lg font-semibold text-gray-700">Desa Rimba Makmur</h1>
    </label>

    <input type="checkbox" id="desa_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <!-- Logo dan Nama Desa -->
            <div class="flex flex-col items-center gap-3">
                <img src="/logo.png" alt="Logo Desa" class="w-full border border-gray-300 shadow-md" />
                <h1 class="text-xl font-bold text-white">Desa Rimba Makmur</h1>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-5 flex flex-col gap-3">
                <a href="/tentang-desa" class="btn btn-accent w-full">Tentang Desa</a>
                <label for="desa_modal" class="btn btn-outline btn-error w-full">Tutup</label>
            </div>
        </div>
        <label class="modal-backdrop" for="desa_modal"></label>
    </div>

    <!-- Salam dan Dropdown User -->
    <div class="flex items-center gap-5">
        <!-- Salam -->
        <h1 class="text-base font-bold text-gray-800">
            Hello, <span class="text-custom-blue">{{ ucfirst(Auth::user()->name) }}</span>
        </h1>

        <!-- Dropdown -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button">
                @if (Auth::user()->image)
                    <img class="w-8 h-8 rounded-full" src="{{ asset('storage/images/' . Auth::user()->image) }}" />
                @else
                    <div class="w-8 h-8">
                        <img class="rounded-full"
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" />
                    </div>
                @endif
            </div>
            <ul tabindex="0"
                class="dropdown-content menu bg-base-100 rounded-lg shadow-lg z-[1] w-52 p-3 border border-gray-200">
                <li>
                    <a href="/profile" class="flex items-center gap-3 text-gray-600 hover:bg-gray-100 p-2 rounded-md">
                        <x-lucide-user-round class="flex-shrink-0 size-5" />
                        Profile
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/+6287746986830?text=Halo Admin saya ingin membuat pengaduan" target="_blank"
                        class="flex items-center gap-3 text-gray-600 hover:bg-gray-100 p-2 rounded-md">
                        <x-lucide-headset class="flex-shrink-0 size-5" />
                        Pengaduan
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" id="logoutBtn"
                            class="flex items-center gap-3 text-gray-600 hover:bg-gray-100 p-2 rounded-md cursor-pointer"
                            onclick="event.preventDefault(); confirmLogout();">
                            <x-lucide-log-out class="flex-shrink-0 size-5" />
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
