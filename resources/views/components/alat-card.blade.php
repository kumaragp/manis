@props([
    'id',
    'nama' => 'Nama Alat',
    'gambar' => 'https://via.placeholder.com/150',
    'status' => 'TERSEDIA',
])

@php
    $statusColor = match($status) {
        'TERSEDIA' => 'bg-green-500',
        'DIGUNAKAN' => 'bg-yellow-500',
        default => 'bg-red-500',
    };
@endphp

<div class="bg-[#8B7355] rounded-2xl p-4 shadow-xl hover:shadow-2xl transition duration-300 h-full">

    <div class="flex gap-4">

        {{-- KIRI: Gambar --}}
        <div class="bg-white rounded-xl p-3 w-40 aspect-square flex items-center justify-center">
            <img 
                src="{{ $gambar }}" 
                alt="{{ $nama }}" 
                class="object-contain w-full h-full"
            >
        </div>

        {{-- KANAN: Info --}}
        <div class="flex-1 flex flex-col justify-center items-start gap-3 py-2">

            {{-- Status --}}
            <span class="{{ $statusColor }} text-white text-xs font-bold px-4 py-1 rounded-full uppercase">
                {{ $status }}
            </span>

            {{-- Nama --}}
            <h3 class="text-white font-bold leading-tight">
                {{ $nama }}
            </h3>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3 mt-1">

                {{-- Pengembalian --}}
                <a href="{{ route('karyawan.return', ['id' => $id]) }}"
                class="bg-white hover:bg-gray-100 text-[#8B7355] rounded-full w-10 h-10 flex items-center justify-center shadow-md transition">
                <i class="fa-solid fa-hand-holding-hand text-xl"></i>
                </a>

                {{-- Report --}}
                <a href="{{ route('karyawan.report', ['id' => $id]) }}"
                class="bg-white hover:bg-gray-100 text-[#8B7355] rounded-full w-10 h-10 flex items-center justify-center shadow-md transition">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </a>


            </div>

        </div>

    </div>

</div>
