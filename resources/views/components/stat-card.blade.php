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

    <i class="fa-solid {{ $icon }} absolute top-4 right-4 text-xl opacity-80"></i>

    <p class="text-sm font-semibold opacity-80 tracking-wide">
        {{ strtoupper($title) }}
    </p>

    <div class="flex items-end space-x-2 mt-2">
        <h2 class="text-4xl font-extrabold leading-none">
            {{ $value }}
        </h2>
        @if ($unit)
            <span class="text-lg opacity-80">{{ $unit }}</span>
        @endif
    </div>

    
</div>