<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete'],
                'deleteRoute' => 'pengadaanAlat.destroy',
                'idField' => 0
            ]">

            <div class="flex justify-center mt-5">
                <div class="grid grid-cols-1 md:grid-cols-3 mb-2 gap-5">
                    <x-stat-card title="Total Alat" value="{{ $totalAlat ?? 0 }}" unit="Unit" icon="fa-screwdriver-wrench"
                        bg="bg-purple-700" />
                    <x-stat-card title="Total Penjualan" value="Rp. {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}"
                        icon="fa-money-bill" bg="bg-green-700" />
                    <x-stat-card title="Rata-rata Harga" value="Rp. {{ number_format($rataRataHarga ?? 0, 0, ',', '.') }}"
                        icon="fa-receipt" bg="bg-blue-700" />
                </div>
            </div>

            Pengadaan Alat

            <x-slot name="actions">
                <x-action-button label="Ajukan Pengadaan" icon="fa-plus" href="{{ route('pengajuanAlat') }}" />
            </x-slot>
        </x-table>

    @else
        <x-form-container action="{{ route('pengadaanAlat.store') }}" method="POST">
            @csrf
            <x-slot:title>
                Pengadaan Alat
            </x-slot:title>
            <x-input-field label="Nama Alat" name="nama_alat" />
            <x-input-field label="Jumlah Alat" name="jumlah" type="number" />
            <x-input-field label="Harga" name="harga" type="text" />
            <x-input-field label="Nama Vendor" name="vendor" />
            <x-input-field label="Tujuan Pengadaan" name="tujuan" />
            <x-input-field label="Tanggal Pembelian" name="tanggal" type="date" />

            <x-slot name="actions">
                <button type="submit"
                    class="inline-flex items-center space-x-2 bg-green-600 px-4 py-2 rounded-full hover:bg-green-700 transition duration-200">
                    <span>Ajukan</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </x-slot>
        </x-form-container>
    @endif
</x-app-layout>