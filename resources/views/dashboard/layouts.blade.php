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
            @if ($pengumuman && isset($pengumuman->file))
                <img id="pengumuman_preview" src="{{ Storage::url($pengumuman->file) }}" class="border size-full"
                    alt="Pengumuman">
            @else
                <img id="pengumuman_preview" src="https://ui-avatars.com/api/?name=Null" class="border size-full" alt="Pengumuman Default">
            @endif

            <form action="{{ route('pengumuman.update', $pengumuman->id ?? 0) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" accept="image/*" id="pengumuman_file" class="hidden" name="image">
                @if (auth()->user()->role == 'Admin')
                    <label for="pengumuman_file" class="w-full cursor-pointer btn btn-sm btn-accent">Ganti</label>
                    <button type="submit" class="w-full cursor-pointer btn btn-sm btn-accent mt-3">Simpan</button>
                @endif
            </form>
        </div>
    </div>
    <label class="modal-backdrop" for="pengumuman_modal"></label>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fotoInput = document.getElementById('pengumuman_file');
        const previewImage = document.getElementById('pengumuman_preview');

        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const blob = URL.createObjectURL(file);
                previewImage.style.display = 'block';
                previewImage.src = blob;
            }
        });
    });
</script>
