<aside class="hidden lg:flex w-64 flex-shrink-0 h-screen pb-10 bg-[#121E33]">
    <div class="flex flex-col w-full h-full">

        <div class="h-24 shrink-0"></div>

        <div class="flex-1 px-4 pb-6">
            <nav class="bg-[#0A162B] rounded-3xl border border-[#1F2E4D]
                        py-8 px-4 shadow-2xl h-full flex flex-col">

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

                <div class="flex flex-col justify-between h-full">
                    @foreach($menuItems as $item)
                        <a href="{{ route($item['route']) }}" class="group w-full flex flex-col items-center justify-center
                                      py-5 rounded-xl text-[#54A6EE]
                                      hover:bg-[#F0A92E] hover:text-white
                                      transition-all duration-200 shadow-lg">

                            <i class="fa-solid {{ $item['icon'] }} text-3xl
                                          transition-transform duration-200
                                          group-hover:-translate-y-1"></i>

                            <span class="text-xs text-center mt-1 opacity-0
                                             group-hover:opacity-100 transition">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endforeach
                </div>

            </nav>
        </div>
    </div>
</aside>