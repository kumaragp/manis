<x-app-layout>
    @if ($mode === 'table')

        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete'],
                'deleteRoute' => 'penjualanAlat.destroy',
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
            
            Penjualan Alat

            <x-slot name="actions">
                <x-action-button label="Jual Alat" icon="fa-plus" href="{{ route('jualAlat') }}" />
            </x-slot>

        </x-table>

    @elseif ($mode === 'jualAlat')

        <x-form-container action="{{ route('penjualanAlat.store') }}" method="POST">
            @csrf

            <x-slot:title>
                Jual Alat
            </x-slot:title>

            <x-input-field label="Nama Pembeli" name="nama" />
            <x-select-field label="Alat" name="namaAlat" :options="$alatList->pluck('nama_alat', 'nama_alat')"
                :selected="old('namaAlat')" class="text-white p-2 rounded w-full" />
            <x-input-field label="Jumlah Alat" id="jumlahInput" type="number" name="jumlah" min="1" max="" />
            <x-input-field label="Harga Jual" id="hargaInput" type="number" name="harga" readonly />
            <x-input-field label="Tanggal Penjualan" name="tanggal" type="date" />

            <x-slot name="actions">
                <button type="submit"
                    class="inline-flex items-center space-x-2 bg-green-600 px-4 py-2 rounded-full hover:bg-green-700 transition duration-200">
                    <span>Jual</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </x-slot>

        </x-form-container>
    @endif
</x-app-layout>