@props(['columns', 'rows', 'rowActions' => null, 'rowActionsParams' => []])

@php
    $role = Auth::user()->role ?? 'admin';
    
    $bgTable = $role === 'karyawan' ? 'bg-[#746447]' : 'bg-[#0A3B65]';
    $textColor = $role === 'karyawan' ? 'text-[#ffffff]' : 'text-white';
    $borderColor = $role === 'karyawan' ? 'border-[#8B7355]' : 'border-[#2A3F68]';
    $hoverBg = $role === 'karyawan' ? 'hover:bg-[#8B7355]/50' : 'hover:bg-[#1A2C4D]/70';
@endphp

{{-- JUDUL--}}
<h1 class="text-3xl font-extrabold text-white mb-6 border-b border-white/20 pb-4">
    {{ $slot ?? 'Tabel' }}
</h1>

@if (isset($actions))
    <div class="flex justify-end mb-4">
        {{ $actions }}
    </div>
@endif

{{-- BAGIAN TABEL --}}
<div class="{{ $bgTable }} p-6 rounded-2xl shadow-2xl">
    <div class="overflow-x-auto">
        <table class="min-w-full text-center {{ $textColor }} border-collapse">
            <thead>
                {{-- HAPUS border-b dari sini --}}
                <tr class="uppercase text-sm font-bold tracking-wide">
                    @foreach ($columns as $col)
                        <th class="py-4 px-3 text-base">{{ $col }}</th>
                    @endforeach

                    @if (!!$rowActions)
                        <th class="py-4 px-3 text-base">Action</th>
                    @endif
                </tr>
            </thead>

            {{-- HAPUS divide-y dari sini --}}
            <tbody>
                @foreach ($rows as $row)
                    <tr class="{{ $hoverBg }} transition duration-200">
                        {{-- Cells --}}
                        @foreach ($row as $cell)
                            <td class="py-3 text-lg">{{ $cell }}</td>
                        @endforeach

                        {{-- Row Actions --}}
                        @if ($rowActions)
                            <td class="py-3 flex justify-center">
                                <x-dynamic-component 
                                    :component="$rowActions"
                                    :row="$row"
                                    :allowedActions="$rowActionsParams['allowedActions'] ?? []"
                                    :editRoute="$rowActionsParams['editRoute'] ?? null"
                                    :deleteRoute="$rowActionsParams['deleteRoute'] ?? null"
                                    :reportRoute="$rowActionsParams['reportRoute'] ?? null"
                                    :returnRoute="$rowActionsParams['returnRoute'] ?? null"
                                    :idField="$rowActionsParams['idField'] ?? 0"
                                />
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>