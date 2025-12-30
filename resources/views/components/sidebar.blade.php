<aside class="hidden lg:flex flex-shrink-0 w-64 justify-center pt-16">
    <div class="bg-[#121E33] w-full px-6">
        <nav class="bg-[#0A162B] flex flex-col py-10 px-6 shadow-2xl rounded-3xl border border-[#1F2E4D] mt-16">
            <div class="space-y-6 w-full">

                @php
                    $menuItems = [
                        ['route' => 'riwayatPeminjaman', 'icon' => 'fa-clock-rotate-left', 'label' => 'Riwayat Peminjaman'],
                        ['route' => 'daftarAlat', 'icon' => 'fa-toolbox', 'label' => 'Daftar Alat'],
                        ['route' => 'pengadaanAlat', 'icon' => 'fa-boxes-stacked', 'label' => 'Pengadaan Alat'],
                        ['route' => 'penjualanAlat', 'icon' => 'fa-cart-shopping', 'label' => 'Penjualan Alat'],
                        ['route' => 'perawatanAlat', 'icon' => 'fa-screwdriver-wrench', 'label' => 'Perawatan Alat'],
                        ['route' => 'daftarKaryawan', 'icon' => 'fa-users', 'label' => 'Daftar Karyawan'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="group flex flex-col items-center justify-center p-3 rounded-xl text-[#54A6EE] hover:text-white hover:bg-[#F0A92E] transition-all duration-200 shadow-lg">
                        <i class="fa-solid {{ $item['icon'] }} text-4xl transition-all duration-200 group-hover:mb-1"></i>
                        <span class="text-[14px] text-center leading-tight opacity-0 group-hover:opacity-100 transition-all duration-200 mt-0 group-hover:mt-1">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach

            </div>
        </nav>
    </div>
</aside>