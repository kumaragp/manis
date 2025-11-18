@props(['user'])

@php
    // Tentukan warna navbar berdasarkan role user
    $isAdmin = $user && $user->role === 'admin';
    $navbarColor = $isAdmin ? 'bg-[#0A3B65]' : 'bg-[#73541C]';
    $borderColor = $isAdmin ? 'border-[#2A3F68]' : 'border-[#5A4015]';
@endphp

<header class="flex items-center justify-between p-4 px-20 {{ $navbarColor }} border-b {{ $borderColor }} shadow-lg">

    <a href="{{ route('riwayatPeminjaman') }}" class="flex items-center space-x-3 cursor-pointer">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Kawasan" class="h-10 w-auto">
        <span class="text-2xl font-bold text-white uppercase tracking-wider">
            Kawasan Industri Terpadu Batang
        </span>
    </a>

    <div class="flex items-center space-x-6">
        @if(Auth::user() && Auth::user()->role === 'karyawan')
            <a href="{{ route('profile.edit') }}"
                class="text-white font-semibold text-lg hover:text-gray-300 transition duration-200">
                Profil
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center justify-center space-x-3 px-6 py-2 text-lg text-white font-semibold rounded-xl bg-[#B60000] hover:bg-[#A00000] transition duration-200 shadow-lg hover:shadow-red-900/40">
                <i class="fa-solid fa-arrow-right-from-bracket text-xl"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</header>