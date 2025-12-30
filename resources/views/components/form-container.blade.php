@props(['action', 'method' => 'POST', 'backUrl' => null, 'livewire' => false])

<div {{ $attributes->merge([
    'class' => 'bg-[#0A3B65] w-full max-w-3xl p-8 rounded-2xl shadow-xl text-white'
]) }}>
    @isset($title)
        <h1 class="text-3xl font-extrabold mb-6 border-b border-white/20 pb-4">
            {{ $title }}
        </h1>
    @endisset

    @if($livewire)
        <div class="flex flex-col space-y-4">
            {{ $slot }}
        </div>
    @else
        <form action="{{ $action }}" method="POST">
            @csrf
            @if($method !== 'POST') @method($method) @endif

            <div class="flex flex-col space-y-4">
                {{ $slot }}
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="submit" class="bg-green-500 px-6 py-2 rounded-xl">
                    Simpan
                </button>
                <a href="{{ $backUrl ?? url()->previous() }}" class="bg-red-500 px-6 py-2 rounded-xl">
                    Batal
                </a>
            </div>
        </form>
    @endif
</div>