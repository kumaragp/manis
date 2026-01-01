<div>
    <div class="w-full px-4 sm:px-6 lg:px-0">
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white text-center pt-24 mb-8">
            DAFTAR ALAT
        </h1>

        <div class="w-full max-w-7xl mx-auto">

            <div class="mb-6 flex justify-center lg:justify-start">
                <div class="relative w-full">
                    <input
                        type="text"
                        wire:model.defer="search"
                        wire:keydown.enter="searchData"
                        placeholder="Cari nama alat..."
                        class="w-full pr-10 px-4 py-3 rounded-lg border
                               focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />

                    <i class="fa-solid fa-magnifying-glass
                              absolute right-3 top-1/2 -translate-y-1/2
                              text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                @foreach ($alatList as $item)
                    <div wire:key="alat-{{ $item['id'] }}">
                        <x-alat-card
                            :id="$item['id']"
                            :nama="$item['nama']"
                            :gambar="$item['gambar']"
                            :status="$item['status']"
                            :stok="$item['stok']"
                        >
                            <button
                                wire:click="openPeminjaman({{ $item['id'] }})"
                                class="bg-white rounded-full w-10 h-10 flex items-center justify-center"
                            >
                                <i class="fa-solid fa-hand-holding-hand"></i>
                            </button>

                            <button
                                wire:click="openPelaporan({{ $item['id'] }})"
                                class="bg-white rounded-full w-10 h-10 flex items-center justify-center"
                            >
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </button>
                        </x-alat-card>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @teleport('body')
        <div
            x-cloak
            x-data="{ show: false }"
            x-init="
                $watch('$wire.mode', value => {
                    show = value === 'peminjamanAlat' || value === 'pelaporanAlat'
                    document.body.classList.toggle('overflow-hidden', show)
                })
            "
            x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4"
            @click.self="$wire.closeModal()"
            @keydown.escape.window="$wire.closeModal()"
        >
            <div class="w-full max-w-3xl relative z-50">

                <div x-show="$wire.mode === 'peminjamanAlat'">
                    <x-form-container-karyawan wire:submit.prevent="storePeminjaman" submitText="Pinjam">
                        <x-input-field label="Nama Alat" :value="$selectedAlat?->nama_alat" readonly />
                        <x-input-field
                            label="Jumlah"
                            type="number"
                            min="1"
                            max="{{ $selectedAlat?->jumlah_alat }}"
                            wire:model.defer="jumlah"
                            required
                        />
                    </x-form-container-karyawan>
                </div>

                <div x-show="$wire.mode === 'pelaporanAlat'">
                    <x-form-container-karyawan wire:submit.prevent="storePelaporan" submitText="Lapor">
                        <x-input-field label="Nama Alat" :value="$selectedAlat?->nama_alat" readonly />
                        <x-input-field
                            label="Jumlah"
                            type="number"
                            min="1"
                            max="{{ $selectedAlat?->jumlah_alat }}"
                            wire:model.defer="jumlah"
                            required
                        />
                        <x-input-field label="Deskripsi Kerusakan" wire:model.defer="keterangan" required />
                        <x-input-field label="Tanggal Lapor" type="date" wire:model.defer="tanggal" required />
                    </x-form-container-karyawan>
                </div>

            </div>
        </div>
    @endteleport
</div>