<x-app-layout :user="Auth::user()">
    <x-table :columns="$columns" :rows="$rows">
        Daftar Alat
    </x-table>
</x-app-layout>