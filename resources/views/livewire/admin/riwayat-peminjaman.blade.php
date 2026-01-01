<div>

    <x-table :columns="$columns" :rows="$rows" :pagination="$pagination">
        Riwayat Peminjaman

        <x-slot name="actions">
            <div class="w-full flex items-center gap-3 mb-3">
 
                <div class="relative w-64">
                    <input type="text" wire:model.defer="search" wire:keydown.enter="searchData"
                        placeholder="Cari alat, karyawan, atau status..." 
                        class="w-full pr-10 px-4 py-2 rounded-lg border
                               focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <i class="fa-solid fa-magnifying-glass
                       absolute right-3 top-1/2 -translate-y-1/2
                       text-gray-400 pointer-events-none"></i>
                </div>

                <div class="flex-1"></div>

                <div class="flex items-center gap-2">
                    <x-action-button :label="$sortDirection === 'desc' ? 'Terbaru' : 'Terlama'" 
                                     icon="fa-sort"
                                     wire:click="sortBy('tanggal_pinjam')" />
                </div>
            </div>
        </x-slot>
    </x-table>
</div>
