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
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';

    $bgInput = $isAdmin ? 'bg-[#1A2C4D]' : 'bg-[#6A4A1A]';
    $borderInput = $isAdmin ? 'border-white/20' : 'border-[#5A4015]';
    $hoverBg = $isAdmin ? 'hover:bg-[#2A3F68]' : 'hover:bg-[#7A5620]';
    $labelColor = $isAdmin ? 'text-white' : 'text-[#FFF5E1]';
    $isDate = $type === 'date';
@endphp

<div class="flex flex-col">
    @if($label)
        <label for="{{ $name }}" class="font-semibold mb-1 {{ $labelColor }}">
            {{ $label }}
        </label>
    @endif

    @if($disabled)
        <p class="w-full p-2 rounded-xl {{ $bgInput }} text-white border {{ $borderInput }}">
            {{ $value }}
        </p>

    @elseif(is_array($options))
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-full p-2 rounded-xl {{ $bgInput }} text-white border {{ $borderInput }}">

            @foreach($options as $option)
                <option value="{{ $option }}"
                    @selected(old($name, $value) == $option)
                    class="text-white placeholder-white">
                    {{ $option }}
                </option>
            @endforeach
        </select>

    @elseif($type === 'file')
        <div class="relative">
            <input
                type="file"
                name="{{ $name }}"
                id="{{ $name }}"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                onchange="document.getElementById('{{ $name }}-name').textContent = this.files[0]?.name || ''" />

            <div class="flex items-center justify-between border {{ $borderInput }} rounded-xl {{ $bgInput }} p-2 px-4 cursor-pointer {{ $hoverBg }} transition">
                <span id="{{ $name }}-name" class="text-white truncate ">
                    Pilih file...
                </span>
                <span class="font-bold px-4 py-2 rounded-full shadow-md transition
                             {{ $isAdmin ? 'bg-[#55A0FF] text-[#0A3B65]' : 'bg-[#E0B060] text-[#4A2F0F]' }}">
                    Browse
                </span>
            </div>
        </div>

    @else
        <input
            id="{{ $attributes->get('id') ?? $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder ?? 'Masukkan ' . ($label ?: $name) }}"
            {{ $attributes->merge([
                'class' => "w-full p-2 rounded-xl $bgInput text-white border $borderInput " .
                        ($isDate ? '[color-scheme:dark]' : '')
            ]) }}
        />
    @endif
</div>