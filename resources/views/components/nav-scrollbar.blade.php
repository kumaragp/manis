{{-- nav-scrollbar.blade.php --}}
<div class="py-3 px-4 flex justify-start">
    <div class="overflow-x-auto scrollbar-hide w-fit">
        <div class="inline-flex space-x-3">
            <a href="{{ route('riwayatPeminjamanKaryawan') }}"
               class="flex items-center space-x-2 bg-[#0A3B65] hover:bg-[#0C4A7B]
                      text-white px-4 py-2 rounded-full shadow-md transition min-w-max">
                <i class="fa-solid fa-briefcase text-lg"></i>
                <span class="font-semibold whitespace-nowrap">Riwayat Peminjaman</span>
            </a>

            <a href="{{ route('daftarAlatKaryawan') }}"
               class="flex items-center space-x-2 bg-[#0A3B65] hover:bg-[#0C4A7B]
                      text-white px-4 py-2 rounded-full shadow-md transition min-w-max">
                <i class="fa-solid fa-boxes text-lg"></i>
                <span class="font-semibold whitespace-nowrap">Koleksi Alat</span>
            </a>

            {{-- Tambahkan item lain di sini --}}
        </div>
    </div>
</div>
