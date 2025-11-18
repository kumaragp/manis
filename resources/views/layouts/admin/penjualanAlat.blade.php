<x-app-layout>
    @if ($mode === 'table')
    <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="['allowedActions' => ['delete']]">
        Penjualan Alat
        {{-- Wrapper untuk stat cards --}}
        <div class="flex justify-center">
            <div class="grid grid-cols-1 md:grid-cols-3 mb-2 gap-5">
                <x-stat-card title="Total Alat" value="245" unit="Unit" icon="fa-screwdriver-wrench" bg="bg-purple-700"/>

                <x-stat-card title="Pengeluaran" value="Rp. 1.000.000" icon="fa-money-bill" bg="bg-green-700"
                    compareIcon="fa-arrow-down" compareColor="bg-red-500" compareText="-10%"
                    description="Dibanding Seminggu Lalu" />

                <x-stat-card title="Rata-rata Biaya" value="Rp. 1.251.700" icon="fa-receipt" bg="bg-blue-700"
                    compareIcon="fa-arrow-up" compareColor="bg-green-500" compareText="+4%"
                    description="Dibanding Seminggu Lalu" />
            </div>
        </div>
        <x-slot name="actions">
                <x-action-button label="Jual Alat" icon="fa-plus" href="{{ route('jualAlat') }}" />
            </x-slot>
    </x-table>
    @else
    <x-form-container action="#">
        <x-input-field label="Nama Pembeli" name="nama" />
        <x-input-field label="Nama Alat" name="namaAlat" />
        <x-input-field label="Jumlah Alat" name="jumlah" type="number" />
        <x-input-field label="Harga Jual" name="harga" type="number" />
        <x-input-field label="Tanggal Penjualan" name="tanggal" type="date" />
    </x-form-container>
    @endif
</x-app-layout>