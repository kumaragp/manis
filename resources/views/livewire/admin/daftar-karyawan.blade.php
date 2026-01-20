<div>
    <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
        'allowedActions' => ['edit', 'reset', 'delete'],
        'editMethod' => 'openModal',
        'deleteMethod' => 'delete',
        'resetMethod' => 'resetToken',
        'idField' => 'id'
    ]">
        Daftar Karyawan

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
                    <div class="flex items-center gap-2">
                    <x-action-button :label="$sortDirection === 'desc' ? 'Terbaru' : 'Terlama'" icon="fa-sort"
                        wire:click="sortBy('created_at')" />
                </div>
                    <x-action-button label="Tambah Karyawan" icon="fa-plus" wire:click="showTambah" />
                </div>
            </div>
        </x-slot>
    </x-table>

    <div x-cloak x-show="$wire.mode === 'tambah' || $wire.mode === 'edit'"
        x-data="{ show: @entangle('mode') === 'tambah' || @entangle('mode') === 'edit' }"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">

        <x-form-container :livewire="true" class="w-full max-w-3xl relative z-50">
            <x-slot:title>
                {{ $mode === 'edit' ? 'Edit Karyawan' : 'Tambah Karyawan' }}
            </x-slot:title>

            <x-input-field label="Email" type="email" wire:model.defer="email" />
            <x-input-field label="Nama" wire:model.defer="name" />
            <x-input-field label="Divisi" wire:model.defer="divisi" />

            @if($mode === 'edit')
                <div class="mt-4 p-3 bg-blue-900/30 rounded-xl text-blue-300">
                    Token saat ini: <b>{{ $token }}</b>
                </div>
            @endif

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" wire:click="$set('mode','table')"
                    class="bg-red-500 hover:bg-red-600 px-6 py-2 rounded-xl shadow-lg">
                    Batal
                </button>

                <button type="button" wire:click="{{ $mode === 'edit' ? 'update' : 'store' }}"
                    class="bg-green-500 hover:bg-green-600 px-6 py-2 rounded-xl shadow-lg">
                    Simpan
                </button>
            </div>
        </x-form-container>
    </div>
</div>