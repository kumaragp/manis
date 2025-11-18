<x-app-layout :user="Auth::user()">
    <x-table :columns="$columns" :rows="$rows">
        Riwayat Peminjaman
    </x-table>
</x-app-layout>