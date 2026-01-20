@props([
    'label' => 'Aksi',
    'icon' => null,
    'type' => 'button',
])

<button type="{{ $type }}"
    {{ $attributes->merge([
        'class' => '
                inline-flex items-center justify-center gap-2
                bg-[#55A0FF] hover:bg-[#3B8FE0]
                text-[#0A3B65] font-bold
                shadow-md transition duration-200
    
                px-3 py-3 rounded-full        /* mobile: icon only */
                sm:px-6 sm:py-2 sm:rounded-full
            ',
    ]) }}>
    @if ($icon)
        <i class="fa-solid {{ $icon }} text-base sm:text-sm"></i>
    @endif

    <span class="hidden sm:inline">
        {{ $label }}
    </span>
</button>
