@props([
    'action', 
    'method' => 'POST',
    'title' => null,
])

@php
    $role = Auth::user()->role ?? 'karyawan';
    $bgColor = 'bg-[#746447]';  // warna khusus karyawan
@endphp

@if($title)
    <h1 class="text-4xl font-extrabold text-white text-center mb-8">
        {{ $title }}
    </h1>
@endif

<div class="{{ $bgColor }} p-8 rounded-2xl shadow-2xl text-white">
    <form action="{{ $action }}" method="POST">
        @csrf
        
        @if(!in_array(strtoupper($method), ['GET', 'POST']))
            @method($method)
        @endif

        {{ $slot }}

        <div class="flex justify-end space-x-3 mt-6">
            {{-- Tombol Submit --}}
            <button type="submit"
                class="inline-flex items-center space-x-2 bg-yellow-500 hover:bg-yellow-600
                       text-white font-bold px-6 py-2.5 rounded-full shadow-lg transition">

                <span>Submit</span>
                <i class="fa-solid fa-paper-plane text-lg"></i>
            </button>

            {{-- Tombol Batal --}}
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center space-x-2 bg-gray-500 hover:bg-gray-600
                       text-white font-bold px-6 py-2.5 rounded-full shadow-lg transition">

                <span>Batal</span>
                <i class="fa-solid fa-xmark text-lg"></i>
            </a>
        </div>

    </form>
</div>
