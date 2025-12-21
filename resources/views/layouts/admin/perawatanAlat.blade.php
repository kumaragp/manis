<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['edit', 'reset', 'delete'],
                'editRoute' => 'editPerawatan',
                'deleteRoute' => 'hapusPerawatan',
                'idField' => 'id'
            ]">

            Perawatan Alat

            <x-slot name="actions">
                <x-action-button label="Ajukan Perawatan" icon="fa-plus" href="{{ route('tambahPerawatan') }}" />
            </x-slot>

        </x-table>
    @endif

    @if ($mode === 'tambahPerawatan')
        <x-form-container action="{{ route('storePerawatan') }}" method="POST">
            @csrf

            <x-slot:title>
                Ajukan Perawatan
            </x-slot:title>

            <x-select-field label="Alat" name="namaAlat" :options="$alatList->pluck('nama_alat', 'nama_alat')"
                :selected="old('namaAlat')" class="text-white p-2 rounded w-full" />
            <x-input-field label="Jumlah Alat" id="jumlahInput" type="number" name="jumlah" min="1" max="" />
            <x-input-field label="Teknisi" name="teknisi" />
            <x-input-field label="Tanggal" name="tanggal" type="date" />

            <div class="mt-3">
                <label class="font-semibold">Status</label>
                <select name="status"
                    class="flex items-center justify-between bg-[#1A2C4D] border border-white/20 rounded-lg cursor-pointer hover:bg-[#2A3F68] transition w-full p-2 mt-1">
                    <option value="rusak">Rusak</option>
                    <option value="dalam_perawatan">Dalam Perawatan</option>
                    <option value="diperbaiki">Diperbaiki</option>
                </select>
            </div>

            <x-input-field label="Deskripsi" name="deskripsi" />

        </x-form-container>
    @endif

    @if ($mode === 'editPerawatan')
        <x-form-container action="{{ route('updatePerawatan', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-slot:title>
                Edit Perawatan
            </x-slot:title>

            <x-input-field label="Nama Alat" name="alat" :value="$data->alat->nama_alat" disabled />
            <x-input-field label="Jumlah" name="jumlah"  type="input" :value="$data->jumlah" />
            <x-input-field label="Teknisi" name="teknisi" :value="$data->teknisi" />
            <x-input-field label="Tanggal" name="tanggal" type="date" :value="$data->tanggal" />

            <div class="mt-3">
                <label class="font-semibold text-white">Status</label>

                <select name="status" id="status"
                    class="flex items-center justify-between bg-[#1A2C4D] border border-white/20 rounded-lg cursor-pointer hover:bg-[#2A3F68] transition w-full p-2 mt-1"
                    onchange="document.getElementById('status-display').textContent = this.options[this.selectedIndex].text">
                    <option value="rusak" {{ $data->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="dalam_perawatan" {{ $data->status == 'dalam_perawatan' ? 'selected' : '' }}>Dalam Perawatan
                    </option>
                    <option value="diperbaiki" {{ $data->status == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                </select>
            </div>

            <x-input-field label="Deskripsi" name="deskripsi" :value="$data->deskripsi" />

        </x-form-container>
    @endif

</x-app-layout>