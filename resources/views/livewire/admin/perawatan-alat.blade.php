<div>
    <x-table :columns="$columns" :rows="$rows" :pagination="$pagination" rowActions="table-action-buttons"
        :rowActionsParams="[
            'allowedActions' => ['edit', 'delete'],
            'idField' => 'id'
        ]">

        Perawatan Alat

        <x-slot name="actions">
            <div class="w-full flex items-center gap-3">

                <div class="relative w-64">
                    <input type="text" wire:model.defer="search" wire:keydown.enter="searchData"
                        placeholder="Cari nama alat / teknisi..." class="w-full pr-10 px-4 py-2 rounded-lg border
                               focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <i class="fa-solid fa-magnifying-glass
                       absolute right-3 top-1/2 -translate-y-1/2
                       text-gray-400 pointer-events-none"></i>
                </div>

                <div class="flex-1"></div>

                <div class="flex items-center gap-2">
                    <x-action-button label="Urutkan" icon="fa-sort" wire:click="sortBy('created_at')" />

                    <x-action-button label="Perawatan Alat" icon="fa-plus" wire:click="openModal" />
                </div>
            </div>
        </x-slot>
    </x-table>

    <div x-cloak x-data="{ show: @entangle('isOpen') }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

        <x-form-container :livewire="true" class="w-full max-w-3xl">
            <x-slot:title>
                {{ $perawatanId ? 'Edit Perawatan' : 'Ajukan Perawatan' }}
            </x-slot:title>

            <x-select-field label="Alat" wire:model="alat_id" wire:change="pilihAlat" :options="$alatList"
                :disabled="$perawatanId !== null" />

            <x-input-field label="Jumlah" type="number" min="1" :max="$stok_tersedia" wire:model.defer="jumlah" />
            <x-input-field label="Teknisi" wire:model.defer="teknisi" />
            <x-input-field label="Tanggal" type="date" wire:model.defer="tanggal" />

            <div class="mt-3">
                <label class="font-semibold text-white">Status</label>
                <select wire:model="status" class="w-full bg-[#1A2C4D] text-white rounded-lg p-2 mt-1">
                    <option value="rusak">Rusak</option>
                    <option value="dalam_perawatan">Dalam Perawatan</option>
                    <option value="diperbaiki">Diperbaiki</option>
                </select>
            </div>

            <x-input-field label="Deskripsi" wire:model.defer="deskripsi" />

            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="closeModal" class="bg-red-500 px-6 py-2 rounded-xl">
                    Batal
                </button>

                <button wire:click="save" class="bg-green-500 px-6 py-2 rounded-xl">
                    {{ $perawatanId ? 'Update Data' : 'Simpan' }}
                </button>
            </div>
        </x-form-container>
    </div>
</div>