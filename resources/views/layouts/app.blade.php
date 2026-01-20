<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Manis') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- Navbar -->
    <x-navbar :user="Auth::user()">
        <!-- Hamburger untuk mobile -->
        <div class="lg:hidden flex items-center">
            <button @click="sidebarOpen = true" class="text-white p-2">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
    </x-navbar>

    <!-- Wrapper utama -->
    <div class="min-h-screen 
                {{ Auth::user()->role === 'admin' ? 'flex bg-[#121E33]' : 'bg-[#4C3E24]' }}">

        <!-- Sidebar Admin -->
        @if(Auth::user()->role === 'admin')
            <x-sidebar />

            <!-- Overlay saat sidebar mobile -->
            <div class="fixed inset-0 bg-black/50 z-40 lg:hidden" 
                 x-show="sidebarOpen" 
                 x-transition.opacity
                 @click="sidebarOpen = false">
            </div>

            <!-- Sidebar mobile -->
            <div x-cloak
                 class="fixed inset-y-0 right-0 w-64 bg-[#0A162B] shadow-2xl z-50 lg:hidden transform translate-x-full transition-transform duration-300 ease-in-out"
                 :class="{ 'translate-x-0': sidebarOpen, 'translate-x-full': !sidebarOpen }">
                <button @click="sidebarOpen = false" class="text-white p-4">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>

                <x-sidebar-mobile />
            </div>
        @endif

        <!-- Sidebar Karyawan -->
        @if(Auth::user()->role === 'karyawan' && (request()->routeIs('daftarAlatKaryawan') || request()->routeIs('riwayatPeminjamanKaryawan')))
            <x-nav-scrollbar />
        @endif

        <!-- Main Content -->
        <main class="{{ Auth::user()->role === 'admin' ? 'flex-1' : 'w-full' }} 
                     pt-16 px-6 
                     {{ Auth::user()->role === 'karyawan' ? 'pt-28' : '' }} 
                     overflow-y-auto">
            <div class="w-full">
                {{ $slot }}
            </div>
        </main>

    </div>

    @livewireScripts
</body>


<!-- Autofill Data -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alatData = window.alatData ?? @json(isset($alatList) ? $alatList->keyBy('nama_alat') : []);
        const alatSelect = document.getElementById('namaAlat');
        const jumlahInput = document.getElementById('jumlahInput');
        const hargaInput = document.getElementById('hargaInput');

        if (!alatSelect) return;

        function updateFields() {
            const alat = alatData[alatSelect.value];
            if (!alat) return;

            if (jumlahInput) {
                jumlahInput.max = alat.jumlah_alat;
                if (!jumlahInput.value) jumlahInput.value = alat.jumlah_alat;

                if (jumlahInput.value < 1) jumlahInput.value = 1;
                if (jumlahInput.value > alat.jumlah_alat) jumlahInput.value = alat.jumlah_alat;
            }

            if (hargaInput && jumlahInput) {
                hargaInput.value = alat.harga * jumlahInput.value;
            }
        }

        alatSelect.addEventListener('change', updateFields);

        if (jumlahInput) {
            jumlahInput.addEventListener('input', updateFields);
        }

    });
</script>

<!-- Request Suggestion -->
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('confirm-delete', ({ id }) => {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Tindakan ini tidak bisa dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-data', { id });
                }
            });
        });
        Livewire.on('toast', (data) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data.type,
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });

    });
</script>

</html>