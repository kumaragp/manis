<x-app-layout :user="Auth::user()">

    @if ($mode === 'table' && $peminjaman->count() > 0)
        <x-table :columns="$columns" :rows="$peminjaman" rowActions="table-action-buttons" :rowActionsParams="[
                'allowedActions' => ['report', 'return'],
                'reportRoute' => 'karyawan.report',
                'returnRoute' => 'karyawan.return',
                'idField' => 'id'
            ]">
            Riwayat Peminjaman
        </x-table>

    @elseif ($mode === 'pelaporanAlatPinjam')

        <x-form-container-karyawan title="Kerusakan Alat" action="{{ route('karyawan.report.store', $peminjaman->id) }}" submitText="Lapor"
            method="POST">
            @csrf
            <x-input-field label="Nama Alat" name="nama_alat" :value="$peminjaman->alat->nama_alat ?? ''" readonly
                readonly />
            <x-input-field label="Jumlah" name="jumlah_alat" type="number" min="1" max="{{ $peminjaman->jumlah }}" :value="$peminjaman->jumlah" />
            <x-input-field label="Deskripsi Kerusakan" name="keterangan" required />
            <x-input-field label="Tanggal Lapor" type="date" name="tanggal" required />
        </x-form-container-karyawan>


    @elseif ($mode === 'pengembalianAlat')
        <x-form-container-karyawan title="Pengembalian Alat" action="{{ route('karyawan.return.store', $peminjaman->id) }}" submitText="Ajukan"
            method="POST">
            @csrf
            <x-input-field label="Nama Alat" name="nama_alat" :value="$peminjaman->alat->nama_alat ?? ''" readonly />
            <x-input-field label="Jumlah" name="jumlah_kembali" type="number" min="1" max="{{ $peminjaman->jumlah }}" :value="$peminjaman->jumlah" />
        </x-form-container-karyawan>

    @elseif ($mode === 'peminjamanAlat')

        <x-form-container-karyawan title="Peminjaman Alat" action="{{ route('peminjamanAlat.store', $alat->id) }}" submitText="Pinjam" method="POST">
            @csrf
            <x-input-field label="Nama Alat" name="nama_alat" :value="$alat->nama_alat" readonly />
            <x-input-field label="Jumlah" name="jumlah" type="number" min="1" max="{{$alat->jumlah_alat}}" :value="$alat->jumlah_alat" />

        </x-form-container-karyawan>

    @elseif($mode === 'pelaporanAlat')

        <x-form-container-karyawan title="Pelaporan Alat" action="{{ route('pelaporanAlat', $alat->id) }}" submitText="Lapor" method="POST">
            @csrf
            <x-input-field label="Nama Alat" name="nama_alat" :value="$alat->nama_alat" readonly />
            <x-input-field label="Jumlah" type="number" min="1" max="{{$alat->jumlah_alat}}" :value="$alat->jumlah_alat" />
            <x-input-field label="Deskripsi Kerusakan" name="keterangan" required />
            <x-input-field label="Tanggal Lapor" type="date" name="tanggal" required />
        </x-form-container-karyawan>
    @else
        <div
            class="flex flex-col items-center justify-center mt-24 p-8 bg-opacity-80 rounded-2xl shadow-lg text-white">
            <p class="text-xl font-semibold">Belum ada alat yang dipinjam</p>
        </div>

    @endif

</x-app-layout>