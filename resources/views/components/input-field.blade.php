@props([
    'label' => '',
    'name' => '',
    'type' => 'text',     // text, number, date, file
    'value' => null,
    'placeholder' => null,
    'disabled' => false,
    'options' => null,    // untuk select option
])

<div class="flex flex-col">
    @if($label)
        <label for="{{ $name }}" class="font-semibold text-white mb-1">{{ $label }}</label>
    @endif

    {{-- MODE DISABLED → TEKS ONLY --}}
    @if($disabled)
        <p class="w-full p-2 rounded-xl bg-[#1A2C4D] text-white border border-white/20">
            {{ $value }}
        </p>

    {{-- SELECT OPTION --}}
    @elseif(is_array($options))
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-full p-2 rounded-xl bg-[#1A2C4D] text-white border border-white/20"
        >
            @foreach($options as $option)
                <option value="{{ $option }}"
                    @if(old($name, $value) == $option) selected @endif
                    class="text-black"
                >
                    {{ $option }}
                </option>
            @endforeach
        </select>

    {{-- INPUT FILE --}}
    @elseif($type === 'file')
        <div class="relative">
            <input
                type="file"
                name="{{ $name }}"
                id="{{ $name }}"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                onchange="document.getElementById('{{ $name }}-name').textContent = this.files[0]?.name || ''"
            />
            <div class="flex items-center justify-between border border-white/20 rounded-xl bg-[#1A2C4D] p-2 px-4 cursor-pointer hover:bg-[#2A3F68] transition">
                <span id="{{ $name }}-name" class="text-white truncate">Pilih file...</span>
                <span class="bg-[#55A0FF] hover:bg-[#3B8FE0] text-[#0A3B65] font-bold px-4 py-2 rounded-full shadow-md transition">
                    Browse
                </span>
            </div>
        </div>

    {{-- INPUT UMUM (TEXT / NUMBER / DATE / DLL) --}}
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder ?? 'Masukkan ' . ($label ?: $name) }}"
            class="w-full p-2 rounded-xl bg-[#1A2C4D] text-white border border-white/20"
        />
    @endif
</div>