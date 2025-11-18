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

    <!-- Hanya tampilkan nav-scrollbar jika role karyawan -->
    @if(Auth::user()->role === 'karyawan')
        <x-nav-scrollbar />
    @endif

    <div class="min-h-screen flex 
        {{ Auth::user()->role === 'admin' ? 'bg-[#121E33]' : 'bg-[#4C3E24]' }}">

        <!-- Tampilkan sidebar hanya jika user admin -->
        @if(Auth::user()->role === 'admin')
            <x-sidebar :role="Auth::user()->role" />
        @endif

        <main class="flex-1 mt-16 px-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>