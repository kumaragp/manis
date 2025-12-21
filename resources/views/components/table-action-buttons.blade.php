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
    @if($editRoute && in_array('edit', $allowedActions))
        <a href="{{ route($editRoute, [$idField => $row[$idField]]) }}"
           class="inline-flex items-center space-x-2 bg-[#55A0FF] hover:bg-[#3B8FE0] 
                  text-[#0A3B65] font-bold px-6 py-2 rounded-full shadow-md 
                  transition duration-200">
            <span>Edit</span>
            <i class="fa-solid fa-pen text-lg"></i>
        </a>
    @endif

    <!-- Tombol Hapus -->
    @if($deleteRoute && in_array('delete', $allowedActions))
        <form action="{{ route($deleteRoute, [$idField => $row[$idField]]) }}" 
              method="POST">
            @csrf
            @method('DELETE')

            <button type="button" class="delete-btn inline-flex items-center space-x-2 bg-red-500 px-4 py-2 rounded-full hover:bg-red-600 transition duration-200">
                <span>Hapus</span>
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    @endif

    <!-- Tombol Report -->
    @if($reportRoute && in_array('report', $allowedActions))
        <a href="{{ route($reportRoute, $row[$idField]) }}"
        class="inline-flex items-center space-x-2 bg-yellow-500 px-4 py-2 rounded-full 
                hover:bg-yellow-600 transition duration-200">
            <span>Report</span>
            <i class="fa-solid fa-triangle-exclamation"></i>
        </a>
    @endif
    
    <!-- Tombol Reset -->
    @if ($resetRoute && in_array('reset', $allowedActions))
        <form action="{{ route($resetRoute, [$row[$idField]]) }}" 
            method="POST">
            @csrf

            <button class="inline-flex items-center space-x-2 bg-yellow-500 px-4 py-2 rounded-full 
                        hover:bg-yellow-600 transition duration-200">
                <span>Reset</span>
                <i class="fa-solid fa-rotate-right"></i>
            </button>
        </form>
    @endif

    <!-- Tombol Return -->
    @if($returnRoute && in_array('return', $allowedActions))
        <a href="{{ route($returnRoute, $row[$idField]) }}"
        class="inline-flex items-center space-x-2 bg-green-600 px-4 py-2 rounded-full 
                hover:bg-green-700 transition duration-200">
            <span>Return</span>
            <i class="fa-solid fa-rotate-left"></i>
        </a>
    @endif

</div>