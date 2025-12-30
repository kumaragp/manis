@php
$menuItems = [
    ['route' => 'riwayatPeminjaman', 'icon' => 'fa-clock-rotate-left', 'label' => 'Riwayat Peminjaman'],
    ['route' => 'daftarAlat', 'icon' => 'fa-toolbox', 'label' => 'Daftar Alat'],
    ['route' => 'pengadaanAlat', 'icon' => 'fa-boxes-stacked', 'label' => 'Pengadaan Alat'],
    ['route' => 'penjualanAlat', 'icon' => 'fa-cart-shopping', 'label' => 'Penjualan Alat'],
    ['route' => 'perawatanAlat', 'icon' => 'fa-screwdriver-wrench', 'label' => 'Perawatan Alat'],
    ['route' => 'daftarKaryawan', 'icon' => 'fa-users', 'label' => 'Daftar Karyawan'],
    ['route' => 'logout', 'icon' => 'fa-right-from-bracket', 'label' => 'Logout']
];
@endphp

<div class="flex flex-col w-full space-y-4 mt-4">
    @foreach($menuItems as $item)
        <a href="{{ route($item['route']) }}"
           class="flex items-center w-full text-white bg-[#0A162B] hover:bg-[#F0A92E] p-4 rounded-xl transition-all duration-200 shadow-lg space-x-3">
            <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
            <span class="font-semibold">{{ $item['label'] }}</span>
        </a>
    @endforeach
</div>