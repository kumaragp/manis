@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'disabled' => false,
    'options' => null,
])

@php
    use Illuminate\Support\Str;
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
    $id = $attributes->get('id') ?? Str::slug($label ?: $name, '_');

    $bgInput = $isAdmin ? 'bg-[#1A2C4D]' : 'bg-[#6A4A1A]';
    $borderInput = $isAdmin ? 'border-white/20' : 'border-[#5A4015]';
    $hoverBg = $isAdmin ? 'hover:bg-[#2A3F68]' : 'hover:bg-[#7A5620]';
    $labelColor = $isAdmin ? 'text-white' : 'text-[#FFF5E1]';
    $focusRing = $isAdmin ? 'focus:ring-[#0A3B65]' : 'focus:ring-[#73541C]';
    $focusBorder = $isAdmin ? 'focus:border-[#2E6FA3]' : 'focus:border-[#A77A2F]';
    $isDate = $type === 'date';
@endphp

<div class="flex flex-col">
    @if($label)
        <label for="{{ $id }}" class="font-semibold mb-1 {{ $labelColor }}">
            {{ $label }}
        </label>
    @endif

    {{-- DISABLED --}}
    @if($disabled)
        <p id="{{ $id }}"
            class="w-full p-2 rounded-xl {{ $bgInput }} text-white border {{ $borderInput }}">
            {{ $value }}
        </p>

    {{-- SELECT --}}
    @elseif(is_array($options))
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            class="w-full p-2 rounded-xl {{ $bgInput }} text-white border {{ $borderInput }}
                   focus:outline-none focus:ring-1 {{ $focusRing }} {{ $focusBorder }}" >
            @foreach($options as $option)
                <option value="{{ $option }}" @selected(old($name, $value) == $option)>
                    {{ $option }}
                </option>
            @endforeach
        </select>

    {{-- FILE --}}
    @elseif($type === 'file')
        <div class="relative">
            <input
                type="file"
                id="{{ $id }}"
                name="{{ $name }}"
                {{ $attributes }}
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                onchange="document.getElementById('{{ $id }}-name').textContent = this.files[0]?.name || ''" />

            <div class="flex items-center justify-between border {{ $borderInput }}
                        rounded-xl {{ $bgInput }} p-2 px-4 cursor-pointer {{ $hoverBg }} transition">
                <span id="{{ $id }}-name" class="text-white truncate">
                    Pilih file...
                </span>
                <span class="font-bold px-4 py-2 rounded-full shadow-md transition
                    {{ $isAdmin ? 'bg-[#55A0FF] text-[#0A3B65]' : 'bg-[#E0B060] text-[#4A2F0F]' }}">
                    Browse
                </span>
            </div>
        </div>

    {{-- INPUT DEFAULT --}}
    @else
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder ?? 'Masukkan ' . ($label ?: $name) }}"
            {{ $attributes->merge([
                'class' => "w-full p-2 rounded-xl $bgInput text-white border $borderInput
                            focus:outline-none focus:ring-1 $focusRing $focusBorder "
                            . ($isDate ? '[color-scheme:dark]' : '')
            ]) }}
        />
    @endif
</div>