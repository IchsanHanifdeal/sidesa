<div class="flex justify-between w-full gap-5 mt-4 max-lg:flex-col xl:gap-10 min-h-dvh">
  @include('dashboard.asideLeft')
  <div class="lg:hidden">
    @include('dashboard.asideRight')
  </div>
  @include('dashboard.content')
  <div class="max-lg:hidden">
    @include('dashboard.asideRight')
  </div>
</div>
