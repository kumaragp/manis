@props(['action', 'method' => 'POST', 'backUrl' => null])

<div class="bg-[#0A3B65] p-6 rounded-2xl shadow-xl text-white mt-16">
    <form action="{{ $action }}" method="POST" {{ $attributes->merge([]) }}>

        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        @isset($title)
            <h1 class="text-3xl font-extrabold mb-6 border-b border-white/20 pb-4">
                {{ $title }}
            </h1>
        @endisset

        <div class="flex flex-col space-y-4">
            {{ $slot }}
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 font-bold px-6 py-2 rounded-xl shadow-lg">
                Simpan
            </button>
            <a href="{{ $backUrl ?? url()->previous() }}"
               class="bg-red-500 hover:bg-red-600 font-bold px-6 py-2 rounded-xl shadow-lg">
               Batal
            </a>
        </div>

    </form>
</div>