<nav class="flex justify-between w-full">
  <h1 class="text-xl font-bold">
    Hello, <span class="text-custom-blue">Kejaa</span>
  </h1>
  <div class="dropdown dropdown-end">
    <div tabindex="0" role="button">
      <img class="flex-shrink-0 rounded-full size-10" src="https://avatars.githubusercontent.com/u/93970726?v=4" alt="">
    </div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 drop-shadow-2xl border border-gray-300">
      <li>
        <a href="/profile" class="flex items-center gap-3">
          <x-lucide-user-round class="flex-shrink-0 size-5" />
          Profile
        </a>
      </li>
      <li>
        <a href="/profile" class="flex items-center gap-3">
          <x-lucide-log-out class="flex-shrink-0 size-5" />
          Logout
        </a>
      </li>
    </ul>
  </div>
</nav>
