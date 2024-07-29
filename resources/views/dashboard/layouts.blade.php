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

<input type="checkbox" id="pengumuman_modal" class="modal-toggle" />
<div class="modal" role="dialog">
  <div class="modal-box">
    <h3 class="text-lg font-bold">Pengumuman</h3>
    <div class="flex flex-col w-full gap-3 !h-full mt-3 rounded-lg overflow-hidden">
      <img id="pengumuman_preview" src="" class="border size-full" alt="">
      <input type="file" accept="image/*" id="pengumuman_file" class="hidden" name="image">
      <label for="pengumuman_file" class="w-full cursor-pointer btn btn-sm btn-accent">Ganti</label>
    </div>
  </div>
  <label class="modal-backdrop" for="pengumuman_modal"></label>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const fotoInput = document.getElementById('pengumuman_file');
    const previewImage = document.getElementById('pengumuman_preview');
    previewImage.src = "/pengumuman.webp"

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
