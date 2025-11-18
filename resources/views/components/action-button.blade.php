@props([
    'label' => 'Aksi',
    'href' => '#',
    'icon' => 'fa-plus'
])

<a href="{{ $href }}"
   class="inline-flex items-center space-x-2 bg-[#55A0FF] hover:bg-[#3B8FE0] 
          text-[#0A3B65] font-bold px-6 py-2 rounded-full shadow-md 
          transition duration-200">

    <span>{{ $label }}</span>
    <i class="fa-solid {{ $icon }} text-lg"></i>
</a>