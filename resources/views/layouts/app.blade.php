<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Manis') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <x-navbar :user="Auth::user()" />

    
    <div class="min-h-screen 
    {{ Auth::user()->role === 'admin' ? 'bg-[#121E33]' : 'bg-[#4C3E24]' }}
    {{ Auth::user()->role === 'admin' ? 'flex' : '' }}">
    
    <!-- Hanya tampilkan nav-scrollbar jika role karyawan -->
        @if(
            Auth::user()->role === 'karyawan' &&
            (request()->routeIs('daftarAlatKaryawan') || request()->routeIs('riwayatPeminjamanKaryawan'))
        )
            <x-nav-scrollbar />
        @endif

        <!-- Tampilkan sidebar hanya jika user admin -->
        @if(Auth::user()->role === 'admin')
            <x-sidebar :role="Auth::user()->role" />
        @endif

        <main class="{{ Auth::user()->role === 'admin' ? 'flex-1' : 'w-full' }} mt-16 px-6 {{ Auth::user()->role === 'karyawan' ? 'pt-20' : '' }}">
            <div class="w-full">
                {{ $slot }}
            </div>
        </main>

    </div>
</body>

</html>