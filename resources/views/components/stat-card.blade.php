@props([
    'title' => 'TITLE',
    'value' => '0',
    'unit' => '',
    'icon' => 'fa-chart-line',
    'bg' => 'bg-purple-700',
    'compareIcon' => 'fa-arrow-up',
    'compareColor' => 'bg-green-500',
    'compareText' => '+0%',
    'description' => 'Dibanding Minggu Lalu',
])

<div class="{{ $bg }} text-white p-5 rounded-2xl shadow-lg relative w-64">

    {{-- Icon pojok kanan atas --}}
    <i class="fa-solid {{ $icon }} absolute top-4 right-4 text-xl opacity-80"></i>

    {{-- Title --}}
    <p class="text-sm font-semibold opacity-80 tracking-wide">
        {{ strtoupper($title) }}
    </p>

    {{-- Value --}}
    <div class="flex items-end space-x-2 mt-2">
        <h2 class="text-4xl font-extrabold leading-none">
            {{ $value }}
        </h2>
        @if ($unit)
            <span class="text-lg opacity-80">{{ $unit }}</span>
        @endif
    </div>

    {{-- Compare badge --}}
    <div class="flex items-center space-x-2 mt-3">
        <span class="text-xs {{ $compareColor }} text-white px-2 py-1 rounded-full inline-flex items-center">
            <i class="fa-solid {{ $compareIcon }} text-xs mr-1"></i>
            {{ $compareText }}
        </span>

        <span class="text-xs opacity-90">
            {{ $description }}
        </span>
    </div>
</div>