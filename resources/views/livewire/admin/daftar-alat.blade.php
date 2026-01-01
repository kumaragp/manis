<div>
    <!-- Tabel -->
    <x-table :columns="$columns" :rows="$rows" :pagination="$pagination" :pagination="$pagination"
        rowActions="table-action-buttons" :rowActionsParams="[
        'allowedActions' => ['edit', 'delete'],
        'idField' => 'id'
    ]">
        Daftar Alat

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
                    <x-action-button :label="$sortDirection === 'desc' ? 'Terbaru' : 'Terlama'" icon="fa-sort"
                        wire:click="sortBy('created_at')" />
                    <x-action-button label="Tambah Alat" icon="fa-plus" wire:click="openModal" />
                </div>
            </div>
        </x-slot>
    </x-table>

    <!-- Modal Tambah/Edit Alat -->
    <div x-cloak wire:key="modal-{{ $alatId ?? 'new' }}" x-data="{ show: @entangle('isOpen') }" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

        <x-form-container :livewire="true" class="w-full max-w-3xl relative z-50">
            <x-slot:title>{{ $alatId ? 'Edit Alat' : 'Tambah Alat' }}</x-slot:title>

            <x-input-field label="Nama Alat" wire:model.defer="nama_alat" />
            <x-input-field label="Jumlah" type="number" min="1" wire:model.defer="jumlah_alat" />
            <x-input-field label="Harga" wire:model.defer="harga" />
            <x-input-field label="Gambar" name="gambar" type="file" wire:model="gambar" />

            <!-- Preview Gambar Saat Edit -->
            @if($gambar)
                <img src="{{ $gambar->temporaryUrl() }}" alt="Preview" class="mt-2 w-32 h-32 object-cover rounded-lg">
            @elseif($isEdit && $alatId && $rows)
                @php
                    $currentRow = collect($rows)->firstWhere('id', $alatId);
                @endphp
                @if($currentRow && $currentRow['gambar'])
                    <img src="{{ asset('storage/' . $currentRow['gambar']) }}" alt="Gambar Alat"
                        class="mt-2 w-32 h-32 object-cover rounded-lg">
                @endif
            @endif

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" wire:click="closeModal"
                    class="bg-red-500 hover:bg-red-600 font-bold px-6 py-2 rounded-xl shadow-lg">
                    Batal
                </button>
                <button type="button" wire:click="save"
                    class="bg-green-500 hover:bg-green-600 font-bold px-6 py-2 rounded-xl shadow-lg">
                    Simpan
                </button>
            </div>
        </x-form-container>
    </div>

</div>