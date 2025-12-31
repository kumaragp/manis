<div class="mt-24">
    @if($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['report', 'return'],
                'reportAction' => 'openPelaporan',
                'returnAction' => 'openPengembalian',
                'idField' => 'id'
            ]">
            Riwayat Peminjaman
            <x-slot name="actions">
                <div class="w-full flex items-center gap-3">
                    <div class="relative w-64">
                        <input type="text" wire:model.defer="search" wire:keydown.enter="searchData"
                            placeholder="Cari nama alat..." class="w-full pr-10 px-4 py-2 rounded-lg border
                          focus:outline-none focus:ring-2 focus:ring-blue-500" />

                        <i class="fa-solid fa-magnifying-glass
               absolute right-3 top-1/2 -translate-y-1/2
               text-gray-400 pointer-events-none"></i>
                    </div>


                    <div class="flex-1"></div>

                    <div class="flex items-center gap-2">
                        <x-action-button label="Urutkan" icon="fa-sort" wire:click="sortBy('created_at')" />
                    </div>
                </div>
            </x-slot>
        </x-table>
    @endif

    @if($mode === 'pelaporan')
        <div x-cloak wire:key="report-{{ $selectedPeminjaman->id }}" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

            <x-form-container-karyawan wire:submit.prevent="storePelaporan" submitText="Report">
                <x-input-field label="Nama Alat" :value="$selectedPeminjaman->alat->nama_alat" readonly />
                <x-input-field label="Jumlah Rusak" type="number" min="1" max="{{ $selectedPeminjaman->jumlah }}"
                    wire:model.defer="jumlah" required />
                <x-input-field label="Deskripsi Kerusakan" wire:model.defer="keterangan" required />
                <x-input-field label="Tanggal Lapor" type="date" wire:model.defer="tanggal" required />
            </x-form-container-karyawan>
        </div>
    @endif

    @if($mode === 'pengembalian')
        <div x-cloak wire:key="return-{{ $selectedPeminjaman->id }}" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

            <x-form-container-karyawan wire:submit.prevent="storePengembalian" submitText="Return">
                <x-input-field label="Nama Alat" :value="$selectedPeminjaman->alat->nama_alat" readonly />
                <x-input-field label="Jumlah Dikembalikan" type="number" min="1" max="{{ $selectedPeminjaman->jumlah }}"
                    wire:model.defer="jumlah" required />
            </x-form-container-karyawan>
        </div>
    @endif
</div>