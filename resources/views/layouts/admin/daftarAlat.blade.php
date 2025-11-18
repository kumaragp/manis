<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete', 'edit'],
                'editRoute' => 'editAlat',
                'idField' => 0
            ]">

            Daftar Alat

            <x-slot name="actions">
                <x-action-button label="Tambah Alat" icon="fa-plus" href="{{ route('tambahAlat') }}" />
            </x-slot>

        </x-table>
    @elseif ($mode === 'tambahAlat')
        <x-form-container action="#">
            <x-input-field label="Nama Alat" name="nama" />
            <x-input-field label="Jumlah" name="jumlah" type="number" />
            <x-input-field label="Masukkan Gambar" name="gambar" type="file" />
        </x-form-container>
    @else
        <x-form-container action="#">
            <x-input-field label="Nama Alat" name="nama" :value="$alat->nama ?? 'Nama Barang'" :disabled="true" />
            <x-input-field label="Jumlah" name="jumlah" type="number" />
        </x-form-container>
    @endif
</x-app-layout>