<div>
    <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
        'allowedActions' => ['edit', 'delete'],
        'idField' => 'id'
    ]">

        Daftar Alat

        <x-slot name="actions">
            <x-action-button wire:click="openModal" label="Tambah Alat" icon="fa-plus" />
        </x-slot>

    </x-table>

    <!-- Modal -->
    <div x-cloak wire:key="modal-{{ $alatId ?? 'new' }}" x-data="{ show: @entangle('isOpen') }" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

        <x-form-container :livewire="true" class="w-full max-w-3xl relative z-50">
            <x-slot:title>{{ $alatId ? 'Edit Alat' : 'Tambah Alat' }}</x-slot:title>

            <x-input-field label="Nama Alat" wire:model.defer="nama_alat" />
            <x-input-field label="Jumlah" type="number" wire:model.defer="jumlah_alat" />
            <x-input-field label="Harga" wire:model.defer="harga" />
            <x-input-field label="Gambar" name="gambar" type="file" wire:model="gambar" />

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