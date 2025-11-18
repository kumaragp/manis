<x-app-layout>
    @if ($mode === 'table')
        <x-table :columns="$columns" :rows="$rows" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['delete'],
                'deleteRoute' => 'admin.karyawan.delete',
                'idField' => 4
            ]">
            Daftar Karyawan
            <x-slot name="actions">
                <x-action-button label="Tambah Karyawan" icon="fa-plus" href="{{ route('admin.karyawan.tambah') }}" />
            </x-slot>
        </x-table>
    @else
        <x-form-container action="{{ route('admin.karyawan.store') }}" method="POST">
            <x-input-field label="Email" name="email" type="email" />
            <x-input-field label="Nama Karyawan" name="name" />
            <x-input-field label="Divisi" name="divisi" />
            <x-input-field label="Kata Sandi/Token" name="password" type="password" />
        </x-form-container>
    @endif
</x-app-layout>