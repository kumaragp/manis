@props([
    'row', 
    'allowedActions' => [], 
    'editRoute' => null, 
    'deleteRoute' => null,
    'reportRoute' => null,
    'returnRoute' => null,
    'idField' => 0
])

<div class="flex space-x-2">

    {{-- Tombol Edit --}}
    @if($editRoute && in_array('edit', $allowedActions))
        <a href="{{ route($editRoute, ['id' => $row[$idField]]) }}"
           class="inline-flex items-center space-x-2 bg-[#55A0FF] hover:bg-[#3B8FE0] 
                  text-[#0A3B65] font-bold px-6 py-2 rounded-full shadow-md 
                  transition duration-200">
            <span>Edit</span>
            <i class="fa-solid fa-pen text-lg"></i>
        </a>
    @endif

    {{-- Tombol Hapus --}}
    @if($deleteRoute && in_array('delete', $allowedActions))
        <form action="{{ route($deleteRoute, ['id' => $row[$idField]]) }}" 
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

    {{-- REPORT BUTTON --}}
    @if($reportRoute && in_array('report', $allowedActions))
        <a href="{{ route($reportRoute, ['id' => $row[$idField]]) }}"
        class="inline-flex items-center space-x-2 bg-yellow-500 px-4 py-2 rounded-full 
                hover:bg-yellow-600 transition duration-200">
            <span>Report</span>
            <i class="fa-solid fa-triangle-exclamation"></i>
        </a>
    @endif

    {{-- RETURN BUTTON --}}
    @if($returnRoute && in_array('return', $allowedActions))
        <a href="{{ route($returnRoute, ['id' => $row[$idField]]) }}"
        class="inline-flex items-center space-x-2 bg-green-600 px-4 py-2 rounded-full 
                hover:bg-green-700 transition duration-200">
            <span>Return</span>
            <i class="fa-solid fa-rotate-left"></i>
        </a>
    @endif


</div>