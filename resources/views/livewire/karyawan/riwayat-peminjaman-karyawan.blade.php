<div x-data>

    <div class="mt-24">
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons"
            :rowActionsParams="[
                'allowedActions' => ['report', 'return'],
                'reportAction' => 'openPelaporan',
                'returnAction' => 'openPengembalian',
                'idField' => 'id'
            ]">
            Riwayat Peminjaman
        </x-table>
    </div>

    @teleport('body')
    <div
        x-cloak
        x-data="{ show: false }"
        x-init="
            $watch('$wire.mode', value => {
                show = value === 'pelaporan' || value === 'pengembalian'
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

            <div x-show="$wire.mode === 'pelaporan'">
                <x-form-container-karyawan wire:submit.prevent="storePelaporan" submitText="Report">
                    <x-input-field label="Nama Alat" :value="$selectedPeminjaman?->alat?->nama_alat" readonly />
                    <x-input-field label="Jumlah Rusak" type="number"
                        min="1" max="{{ $selectedPeminjaman?->jumlah }}"
                        wire:model.defer="jumlah" required />
                    <x-input-field label="Deskripsi Kerusakan" wire:model.defer="keterangan" required />
                    <x-input-field label="Tanggal Lapor" type="date" wire:model.defer="tanggal" required />
                </x-form-container-karyawan>
            </div>

            <div x-show="$wire.mode === 'pengembalian'">
                <x-form-container-karyawan wire:submit.prevent="storePengembalian" submitText="Return">
                    <x-input-field label="Nama Alat" :value="$selectedPeminjaman?->alat?->nama_alat" readonly />
                    <x-input-field label="Jumlah Dikembalikan" type="number"
                        min="1" max="{{ $selectedPeminjaman?->jumlah }}"
                        wire:model.defer="jumlah" required />
                </x-form-container-karyawan>
            </div>

        </div>
    </div>
    @endteleport

</div>