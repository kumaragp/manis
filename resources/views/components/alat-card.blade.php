@props([
    'id',
    'nama',
    'gambar',
    'status',
    'stok' => 0,
])
@php
    $finalStatus = $stok == 0 ? 'STOK HABIS' : $status;

    $statusColor = match ($finalStatus) {
        'TERSEDIA' => 'bg-green-500',
        'DIGUNAKAN', 'SEDANG DIGUNAKAN' => 'bg-yellow-500',
        'DALAM PERAWATAN' => 'bg-blue-500',
        'STOK HABIS', 'RUSAK' => 'bg-red-500',
        default => 'bg-gray-500',
    };
@endphp

<div class="bg-[#8B7355] rounded-2xl p-4 shadow-xl hover:shadow-2xl transition duration-300 h-full">
    <div class="flex gap-4">
        @if (!empty($gambar))
            <div class="bg-white rounded-xl w-40 h-40 overflow-hidden flex items-center justify-center">
                <img src="{{ asset('storage/' . $gambar) }}">
            </div>
        @else
            <div class="bg-white rounded-xl w-40 h-40 overflow-hidden flex items-center justify-center">
                <i class="fa-regular fa-image text-6xl"></i>
            </div>
        @endif

        <div class="flex-1 flex flex-col justify-center items-start gap-3 py-2">
            <span class="{{ $statusColor }} text-white text-xs font-bold px-4 py-1 rounded-full uppercase">
                {{ $finalStatus }}
            </span>
            <h3 class="text-white font-bold leading-tight">{{ $nama }}</h3>
            <p class="text-white/80 text-sm">Stok: <span class="font-semibold">{{ $stok }}</span></p>

            <div class="flex gap-3 mt-1">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>