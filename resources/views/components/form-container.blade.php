@props(['action', 'method' => 'POST'])

<div class="bg-[#0A3B65] p-6 rounded-2xl shadow-xl text-white">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col space-y-4">
            {{ $slot }}
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button
                class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-2 rounded-xl shadow-lg">
                Simpan
            </button>

            <a href="{{ url()->previous() }}"
               class="bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-2 rounded-xl shadow-lg">
                Batal
            </a>
        </div>
    </form>
</div>