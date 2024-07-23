<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidesa</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white bg-[#2e319a] h-screen flex justify-evenly flex-col antialiased px-3 py-2">
    <section>
        <h1 class="text-5xl text-center font-extrabold">SIDESA</h1>
        <h1 class="text-sm text-center font-extrabold">Sistem Informasi Desa</h1>
    </section>

    <section class="flex gap-2 flex-col items-center">
        <a
        href="{{ route('register') }}"
            class="bg-gradient-to-r from-blue-500 to-blue-800 hover:from-blue-800 hover:to-blue-500 text-white font-bold py-2 w-48 text-center rounded-[40px]">
            Daftar DESA
        </a>
        <a
        href="{{ route('register-warga') }}"
            class="bg-gradient-to-r from-blue-500 to-blue-800 hover:from-blue-800 hover:to-blue-500 text-white font-bold py-2 w-48 text-center rounded-[40px]">
            Daftar Akun
        </a>

        <a
        href="{{ route('login') }}"
            class="bg-gradient-to-r from-blue-500 to-blue-800 hover:from-blue-800 hover:to-blue-500 text-white font-bold py-2 w-48 text-center rounded-[40px]">
            Masuk
        </a>

    </section>
</body>

</html>
