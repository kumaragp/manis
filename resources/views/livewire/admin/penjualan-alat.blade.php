<div>
    <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
        'allowedActions' => ['delete'],
        'idField' => 'id'
    ]">
        Penjualan Alat

        <div class="flex justify-center mt-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-stat-card title="Total Alat Terjual" value="{{ $totalAlat ?? 0 }}" unit="Unit"
                    icon="fa-screwdriver-wrench" bg="bg-purple-700" />

                <x-stat-card title="Total Penjualan" value="Rp. {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}"
                    icon="fa-money-bill" bg="bg-green-700" />

                <x-stat-card title="Rata-rata Harga" value="Rp. {{ number_format($rataRataHarga ?? 0, 0, ',', '.') }}"
                    icon="fa-receipt" bg="bg-blue-700" />
            </div>
        </div>

        <x-slot name="actions">
            <x-action-button wire:click="openModal" label="Jual Alat" icon="fa-plus" />
        </x-slot>
    </x-table>

    <div x-cloak wire:key="modal-{{ $penjualanId ?? 'new' }}" x-data="{ show: @entangle('isOpen') }" x-show="show"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-white/5 backdrop-blur-md flex items-center justify-center z-50 p-4">
        <x-form-container :livewire="true" class="w-full max-w-3xl relative z-50">
            <x-slot:title>
                {{ $penjualanId ? 'Edit Penjualan Alat' : 'Jual Alat' }}
            </x-slot:title>

            <x-input-field label="Nama Pembeli" wire:model.live="customer" />
            <x-select-field label="Alat" wire:model="alat_id" wire:change="pilihAlat" :options="$alatList" />
            <x-input-field label="Jumlah" type="number" min="1" :max="$stok_tersedia" wire:model.live="jumlah" />
            <x-input-field label="Harga" type="number" readonly wire:model="harga_total" />
            <x-input-field label="Gambar" name="gambar" type="file" wire:model="gambar" />
            <x-input-field label="Tanggal Penjualan" type="date" wire:model.defer="tanggal" />
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