<x-app-layout>
    <div class="py-5 px-3 flex gap-2 flex-wrap">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf 
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" id="foto" name="foto" accept="image/*" class="file-input file-input-info file-input-bordered file-input-md w-full max-w-xs">
                    <img id="preview" class="mt-2" alt="Preview" style="mt-2 border rounded-lg w-full max-h-[300px] object-cover hidden">
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan Gambar</label>
                    <textarea id="keterangan"
                    placeholder="Keterangan Gambar"
                    name="keterangan" rows="3" class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="flex items-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('galeri') }}" class="ml-2 btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
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
