<x-app-layout>

    @if ($mode === 'table')

        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['edit', 'reset', 'delete'],
                'editRoute' => 'admin.karyawan.edit',
                'deleteRoute' => 'admin.karyawan.delete',
                'resetRoute' => 'admin.karyawan.reset',
                'idField' => 'id'
            ]">

            Daftar Karyawan

            <x-slot name="actions">
                <x-action-button label="Tambah Karyawan" icon="fa-plus" href="{{ route('admin.karyawan.tambah') }}" />
            </x-slot>

        </x-table>

    @endif

    @if ($mode === 'tambah')
        <x-form-container action="{{ route('admin.karyawan.store') }}" method="POST">
            @csrf

            <x-slot:title>
                Daftar Karyawan
            </x-slot:title>

            <x-input-field label="Email" name="email" type="email" />
            <x-input-field label="Nama" name="name" />
            <x-input-field label="Divisi" name="divisi" />
        </x-form-container>
    @endif

    @if ($mode === 'edit')
        <x-form-container action="{{ route('admin.karyawan.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-slot:title>
                Edit Karyawan
            </x-slot:title>

            <x-input-field label="Email" name="email" type="email" :value="$data->email" />
            <x-input-field label="Nama" name="name" :value="$data->name" />
            <x-input-field label="Divisi" name="divisi" :value="$data->divisi" />

            <div class="mt-4 p-3 bg-blue-900/30 rounded-xl text-blue-300">
                Token saat ini: <b>{{ $data->token }}</b>
            </div>

            
        </x-form-container>
    @else
        <div class="text-center text-gray-500 mt-10">
            Tidak ada karyawan
        </div>
    @endif

</x-app-layout>