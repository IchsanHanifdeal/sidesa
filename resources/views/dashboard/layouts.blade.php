<div class="flex justify-between w-full gap-2 mt-4 sm:gap-5 max-lg:flex-col xl:gap-10 min-h-dvh">
  <div class="lg:hidden">
    @include('dashboard.asideRight')
  </div>
  @include('dashboard.asideLeft')
  @include('dashboard.content')
  <div class="max-lg:hidden">
    @include('dashboard.asideRight')
  </div>
</div>
