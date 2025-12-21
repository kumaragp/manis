@props(['user'])

@php
    $isAdmin = $user && $user->role === 'admin';
    $navbarColor = $isAdmin ? 'bg-[#0A3B65]' : 'bg-[#73541C]';
    $borderColor = $isAdmin ? 'border-[#2A3F68]' : 'border-[#5A4015]';
@endphp

<header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-4 sm:px-8 lg:px-20 py-3 {{ $navbarColor }} border-b {{ $borderColor }} shadow-lg">

    <div class="flex items-center space-x-3">
        
        <a href="{{ Auth::user()->role === 'admin' ? route('riwayatPeminjaman') : route('riwayatPeminjamanKaryawan') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" class="w-16 h-auto">
            <span class="pl-6 text-2xl sm:text-lg lg:text-2xl 2xl:text-3xl font-bold text-white uppercase leading-tight">
                Kawasan Industri<br class="md:hidden"> Terpadu Batang
            </span>
        </a>
        
    </div>
    
    <div class="flex items-center space-x-3">
        
        <button class="lg:hidden text-white text-2xl" @click="sidebarOpen = true">
            <i class="fa-solid fa-bars"></i>
        </button>

        <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-8 py-3 text-lg text-white font-semibold rounded-xl bg-[#B60000] hover:bg-[#A00000] transition shadow-lg">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</header>