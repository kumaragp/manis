@props([
    'label' => '',
    'name',
    'options' => [],
    'selected' => null
])

<div class="flex flex-col">
    @if ($label)
        <label for="{{ $name }}" class="text-white font-semibold pb-1">
            Nama {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select 
            name="{{ $name }}" 
            id="{{ $name }}"
            class="flex items-center justify-between bg-[#1A2C4D] border border-white/20 rounded-lg cursor-pointer hover:bg-[#2A3F68] transition w-full"
            onchange="document.getElementById('{{ $name }}-display').textContent = this.options[this.selectedIndex].text" >
            <option value="">Pilih {{ $label }}</option>
            @foreach ($options as $value => $display)
                <option value="{{ $value }}" @selected($selected == $value)>
                    {{ $display }}
                </option>
            @endforeach
        </select>
    </div>

    @error($name)
        <span class="text-red-400 text-sm">{{ $message }}</span>
    @enderror
</div>