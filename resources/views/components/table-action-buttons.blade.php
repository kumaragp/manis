@props([
    'row', 
    'allowedActions' => [], 
    'editRoute' => null, 
    'deleteRoute' => null,
    'reportRoute' => null,
    'returnRoute' => null,
    'resetRoute' => null,
    'idField' => 'id'
])

<div class="flex space-x-2">

    <!-- Tombol Edit -->
    @if(in_array('edit', $allowedActions))
        @if(($row['can_edit'] ?? true))
            <button wire:click="openModal({{ $row[$idField] }})"
                class="inline-flex items-center space-x-2 bg-[#55A0FF] hover:bg-[#3B8FE0] 
                text-[#0A3B65] font-bold px-6 py-2 rounded-full shadow-md transition">
                <span>Edit</span>
                <i class="fa-solid fa-pen text-lg"></i>
            </button>
         @else
             <button
                disabled
                title="Perawatan sudah diperbaiki"
                class="inline-flex items-center space-x-2 bg-gray-400 
              text-white font-bold px-6 py-2 rounded-full shadow-md cursor-not-allowed">
                <span>Edit</span>
                <i class="fa-solid fa-lock text-lg"></i>
            </button>
        @endif
    @endif

    <!-- Tombol Hapus -->
    @if(in_array('delete', $allowedActions))
        <button
            wire:click="$dispatch('confirm-delete', { id: {{ $row[$idField] }} })"
            class="inline-flex items-center space-x-2 bg-red-500 px-4 py-2 rounded-full hover:bg-red-600 transition">
            <span>Hapus</span>
            <i class="fa-solid fa-trash text-lg"></i>
        </button>
    @endif

     <!-- Tombol Reset -->
    @if(in_array('reset', $allowedActions))
        <button wire:click="resetToken({{ $row[$idField] }})"
            class="inline-flex items-center space-x-2 bg-yellow-500 px-4 py-2 rounded-full hover:bg-yellow-600 transition">
            <span>Reset</span>
            <i class="fa-solid fa-rotate-right text-lg"></i>
        </button>
    @endif

    <!-- Tombol Report -->
   @if(in_array('report', $allowedActions))
        <button wire:click="openPelaporan({{ $row[$idField] }})"
            class="inline-flex items-center space-x-2 bg-yellow-500 px-4 py-2 rounded-full
                hover:bg-yellow-600 transition">
            <span>Report</span>
            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
        </button>
    @endif

    <!-- Tombol Return -->
    @if(in_array('return', $allowedActions))
        <button wire:click="openPengembalian({{ $row[$idField] }})"
            class="inline-flex items-center space-x-2 bg-green-600 px-4 py-2 rounded-full
                hover:bg-green-700 transition">
            <span>Return</span>
            <i class="fa-solid fa-rotate-left text-lg"></i>
        </button>
    @endif
</div>