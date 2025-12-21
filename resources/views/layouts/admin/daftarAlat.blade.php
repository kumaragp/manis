<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete', 'edit'],
                'editRoute' => 'editAlat',
                'deleteRoute' => 'hapusAlat',
                'idField' => 'id'
            ]">

            Daftar Alat

            <x-slot name="actions">
                <x-action-button label="Tambah Alat" icon="fa-plus" href="{{ route('tambahAlat') }}" />
            </x-slot>

        </x-table>

    @elseif ($mode === 'tambahAlat')
        <x-form-container action="{{ route('simpanAlat') }}" enctype="multipart/form-data">
            @csrf
            <x-slot:title>
                Daftar Alat
            </x-slot:title>

            <x-input-field label="Nama Alat" name="nama_alat" />
            <x-input-field label="Jumlah" name="jumlah_alat" type="number" />
            <x-input-field label="Harga Satuan" name="harga" />
            <x-input-field label="Gambar" name="gambar" type="file" />
        </x-form-container>


    @else
        <x-form-container action="{{ route('updateAlat', $alat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-slot:title>
                Edit Alat
            </x-slot:title>

            <x-input-field label="Nama Alat" name="nama_alat" :readonly="$readonly" :value="$alat->nama_alat" />
            <x-input-field label="Jumlah" name="jumlah_alat" type="number" :readonly="$readonly" :value="$alat->jumlah_alat" />
            <x-input-field label="Harga Satuan" name="harga" type="text" :readonly="$readonly" :value="$alat->harga" />

            <x-input-field label="Ganti Gambar" name="gambar" :readonly="$readonly" type="file" />

            @if ($alat->gambar)
                <p class="mt-2 text-sm text-gray-600">Gambar saat ini:</p>
                <img src="{{ asset('uploads/alat/' . $alat->gambar) }}" class="w-32 mt-1 rounded" />
            @endif

        </x-form-container>
    @endif
</x-app-layout>