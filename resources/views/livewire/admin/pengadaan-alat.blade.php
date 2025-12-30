<div>
    <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
        'allowedActions' => ['delete'],
        'idField' => 'id'
    ]">
        Pengadaan Alat

        <div class="flex justify-center mt-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-stat-card title="Total Alat" value="{{ $totalAlat ?? 0 }}" unit="Unit" icon="fa-screwdriver-wrench"
                    bg="bg-purple-700" />

                <x-stat-card title="Total Penjualan" value="Rp. {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}"
                    icon="fa-money-bill" bg="bg-green-700" />

                <x-stat-card title="Rata-rata Harga" value="Rp. {{ number_format($rataRataHarga ?? 0, 0, ',', '.') }}"
                    icon="fa-receipt" bg="bg-blue-700" />
            </div>
        </div>
        <x-slot name="actions">
            <x-action-button wire:click="openModal" label="Ajukan Pengadaan" icon="fa-plus" />
        </x-slot>
    </x-table>

    <div x-cloak wire:key="modal-{{ $pengadaanId ?? 'new' }}" x-data="{ show: @entangle('isOpen') }" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">
        <x-form-container :livewire="true" class="w-full max-w-3xl relative z-50">
            <x-slot:title>
                {{ $pengadaanId ? 'Edit Pengadaan Alat' : 'Ajukan Pengadaan Alat' }}
            </x-slot:title>

            <x-input-field label="Nama Alat" wire:model.defer="nama_alat" />
            <x-input-field label="Jumlah" type="number" wire:model.defer="jumlah" />
            <x-input-field label="Harga" wire:model.defer="harga" />
            <x-input-field label="Vendor" wire:model.defer="vendor" />
            <x-input-field label="Tanggal Pembelian" type="date" wire:model.defer="tanggal" />

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" wire:click="closeModal"
                    class="bg-red-500 hover:bg-red-600 px-6 py-2 rounded-xl shadow-lg">
                    Batal
                </button>

                <button type="button" wire:click="save"
                    class="bg-green-500 hover:bg-green-600 px-6 py-2 rounded-xl shadow-lg">
                    Simpan
                </button>
            </div>
        </x-form-container>
    </div>
</div>