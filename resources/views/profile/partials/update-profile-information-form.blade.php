<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('put')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
            <input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                value="{{ old('name', $user->name) }}"
                required
                autocomplete="name"
            >
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nik" class="block text-sm font-medium text-gray-700">{{ __('NIK') }}</label>
            <input
                id="nik"
                name="nik"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                value="{{ old('nik', $user->nik) }}"
                autocomplete="nik"
            >
            @error('nik')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="no_hp" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
            <input
                id="no_hp"
                name="no_hp"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                value="{{ old('no_hp', $user->no_hp) }}"
                autocomplete="tel"
            >
            @error('no_hp')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
            <textarea
                id="alamat"
                name="alamat"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                rows="3"
                autocomplete="alamat"
            >{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Profile Image') }}</label>
            <input
                id="image"
                name="image"
                type="file"
                accept="image/*"
                class="file-input file-input-bordered w-full mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
            >
            @error('image')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <p class="text-sm text-gray-600">
            Pastikan ketika Anda mengubah kordinat ini, Anda berada di rumah Anda.
        </p>

        <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700">{{ __('Latitude') }}</label>
            <input
                id="latitude"
                name="latitude"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                value="{{ old('latitude', $user->lat) }}"
                readonly
            >
            @error('latitude')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700">{{ __('Longitude') }}</label>
            <input
                id="longitude"
                name="longitude"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                value="{{ old('longitude', $user->long) }}"
                readonly
            >
            @error('longitude')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
