<x-app-layout>
    <div class="py-5 px-3 flex gap-2 flex-wrap">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('groups.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="mb-4">
                    <label for="group_name" class="block text-sm font-medium text-gray-700">Nama Grup</label>
                    <input type="text" id="group_name"
                    placeholder="PKK 2024"
                    name="group_name" class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description"
                    placeholder="Grup PKK 2024"
                    name="description" rows="3" class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="file-input file-input-info file-input-bordered file-input-md w-full max-w-xs">
                </div>

                <div class="flex items-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('groups.index') }}" class="ml-2 btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
