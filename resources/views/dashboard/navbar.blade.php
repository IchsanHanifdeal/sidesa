<nav class="flex justify-between w-full">
    <h1 class="text-xl font-bold">
        Hello, <span class="text-custom-blue">{{ ucfirst(Auth::user()->name) }}</span>
    </h1>
    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button">
            @if (Auth::user()->image)
                <img class="rounded-full h-8 w-8" src="{{ asset('storage/images/' . Auth::user()->image) }}" />
            @else
                <div class="w-12 rounded-full">
                    <img class="rounded-full"
                        src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" />
                </div>
            @endif
        </div>
        <ul tabindex="0"
            class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 drop-shadow-2xl border border-gray-300">
            <li>
                <a href="/profile" class="flex items-center gap-3">
                    <x-lucide-user-round class="flex-shrink-0 size-5" />
                    Profile
                </a>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="#" id="logoutBtn" class="flex items-center gap-3 cursor-pointer"
                        onclick="event.preventDefault(); confirmLogout();">
                        <x-lucide-log-out class="flex-shrink-0 size-5" />
                        Logout
                    </a>
                </form>
            </li>
        </ul>

    </div>
</nav>
