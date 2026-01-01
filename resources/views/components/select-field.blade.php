@props([
    'label' => '',
    'name' => null,
    'options' => [],
    'selected' => null
])

<div class="flex flex-col">
    <label class="text-white mb-1">{{ $label }}</label>

    <select
        {{ $attributes->merge(['class' => 'bg-[#1A2C4D] border rounded p-2 rounded-xl']) }}
    >
        <option value="">Pilih {{ $label }}</option>

        @foreach ($options as $id => $nama)
            <option value="{{ $id }}">{{ $nama }}</option>
        @endforeach
    </select>
</div>