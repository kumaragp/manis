@props([
    'action', 
    'method' => 'POST',
    'title' => null,
    'submitText' => 'Submit',
    'submitIcon' => 'fa-paper-plane',
])

@php
    $role = Auth::user()->role ?? 'karyawan';
    $bgColor = 'bg-[#746447]';  // warna khusus karyawan
@endphp

@if($title)
    <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-white/20 pb-4">
        {{ $title }}
    </h1>
@endif

<div class="{{ $bgColor }} w-full max-w-3xl p-8 rounded-2xl shadow-xl text-white">
    <form {{ $attributes }} method="POST">
        @csrf
        
        @if(!in_array(strtoupper($method), ['GET', 'POST']))
            @method($method)
        @endif

        <div class="flex flex-col space-y-4">
            {{ $slot }}
        </div>

        <div class="flex justify-end space-x-3 mt-6">

        <a wire:click="resetModal"
                class="inline-flex items-center space-x-2 bg-red-500 hover:bg-red-600
                       text-white font-bold px-6 py-2.5 rounded-full shadow-lg transition">

                <span>Batal</span>
                <i class="fa-solid fa-xmark text-lg"></i>
            </a>

            <button type="submit"
                class="inline-flex items-center space-x-2 bg-green-500 hover:bg-green-600
                       text-white font-bold px-6 py-2.5 rounded-full shadow-lg transition">

                <span>{{ $submitText }}</span>
                <i class="fa-solid {{ $submitIcon }} text-lg"></i>
            </button>

        </div>

    </form>
</div>