<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete', 'edit'],
                'editRoute' => 'editPerawatan',
                'idField' => 0
            ]">

            Perawatan Alat

            <x-slot name="actions">
                <x-action-button label="Ajukan Perawatan" icon="fa-plus" href="{{ route('tambahPerawatan') }}" />
            </x-slot>

        </x-table>
    @elseif ($mode === 'tambahPerawatan')
        <x-form-container action="#">
            <x-input-field label="Nama Alat" name="nama" />
            <x-input-field label="Jumlah Alat" name="jumlah" type="number" />
            <x-input-field label="Nama Teknisi" name="namaTeknisi" />
            <x-input-field label="Status Perawatan" name="status" type="number" :options="['Tersedia', 'Sedang Digunakan', 'Dalam Perawatan', 'Rusak']" />
            <x-input-field label="Waktu Perawatan" name="waktu" type="date" />
            <x-input-field label="Deskripsi kerusakan" name="deskripsi" />
        </x-form-container>
    @else
        <x-form-container action="#">
            <x-input-field label="Nama Alat" name="nama" :value="$alat->nama ?? 'Nama Alat'" :disabled="true"/>
            <x-input-field label="Jumlah Alat" name="jumlah" type="number" :value="$alat->jumlah ?? 'Jumlah Alat'" :disabled="true" />
            <x-input-field label="Nama Teknisi" name="namaTeknisi" :value="$alat->namaTeknisi ?? 'Nama Teknisi'" :disabled="true" />
            <x-input-field label="Status Perawatan" name="status" :options="['Tersedia', 'Sedang Digunakan', 'Dalam Perawatan', 'Rusak']" :value="$alat->status ?? 'Tersedia'" :disabled="true" />
            <x-input-field label="Waktu Perawatan" name="waktu" type="date" :value="$alat->waktu ?? 'Waktu Perawatan'" :disabled="true" />
            <x-input-field label="Deskripsi kerusakan" name="deskripsi" />
        </x-form-container>
    @endif
</x-app-layout>