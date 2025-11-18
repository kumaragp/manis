@props([
    'row', 
    'allowedActions' => [], 
    'editRoute' => null, 
    'deleteRoute' => null,
])

<div class="flex space-x-2">

    {{-- Tombol Edit --}}
    @if($editRoute && in_array('edit', $allowedActions))
        <a href="{{ route($editRoute, ['id' => $row['id']]) }}"
           class="inline-flex items-center space-x-2 bg-[#55A0FF] hover:bg-[#3B8FE0] 
                  text-[#0A3B65] font-bold px-6 py-2 rounded-full shadow-md 
                  transition duration-200">
            <span>Edit</span>
            <i class="fa-solid fa-pen text-lg"></i>
        </a>
    @endif

    {{-- Tombol Hapus --}}
    @if($deleteRoute && in_array('delete', $allowedActions))
        <form action="{{ route($deleteRoute, ['id' => $row['id']]) }}" 
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
            @csrf
            @method('DELETE')

            <button class="inline-flex items-center space-x-2 bg-red-500 px-4 py-2 rounded-full hover:bg-red-600 transition duration-200">
                <span>Hapus</span>
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    @endif

    {{-- Tombol Cetak --}}
    @if(in_array('print', $allowedActions))
        <x-action-button 
            label="Cetak" 
            icon="fa-print"
            href="#"
        />
    @endif

</div>