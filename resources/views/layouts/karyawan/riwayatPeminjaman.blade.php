<x-app-layout :user="Auth::user()">

    @if ($mode === 'table')
        <x-table 
            :columns="$columns" 
            :rows="$rows" 
            rowActions="table-action-buttons" 
            :rowActionsParams="[
                'allowedActions' => ['report', 'return'],
                'reportRoute' => 'karyawan.report',
                'returnRoute' => 'karyawan.return',
                'idField' => 0
            ]"
        >
            Riwayat Peminjaman
        </x-table>

    @elseif ($mode === 'pelaporanAlat')

        <x-form-container-karyawan 
            title="LAPORAN KERUSAKAN ALAT" 
            action="{{ route('karyawan.report.store') }}"
        >
            <x-input-field label="Nama Alat" name="nama_alat" required />
            <x-input-field label="Deskripsi Kerusakan" name="keterangan" required />
            <x-input-field label="Tanggal Lapor" type="date" name="tanggal" required />

        </x-form-container-karyawan>

    @elseif ($mode === 'pengembalianAlat')

        <x-form-container-karyawan 
            title="PENGEMBALIAN ALAT" 
            action="{{ route('karyawan.return.store') }}"
        >
            <x-input-field label="Nama Alat" name="nama_alat" required />
            <x-input-field label="Jumlah" name="jumlah" type="number" required />
        </x-form-container-karyawan>
    @endif

</x-app-layout>