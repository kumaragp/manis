@props(['columns', 'rows', 'rowActions' => null, 'rowActionsParams' => [], 'pagination' => null, 'searchField' => 'nama_alat', 'sortField' => null, 'sortDirection' => null])

@php
    $role = Auth::user()->role ?? 'admin';

    $bgTable = $role === 'karyawan' ? 'bg-[#746447]' : 'bg-[#0A3B65]';
    $textColor = $role === 'karyawan' ? 'text-[#ffffff]' : 'text-white';
    $borderColor = $role === 'karyawan' ? 'border-[#8B7355]' : 'border-[#2A3F68]';
    $hoverBg = $role === 'karyawan' ? 'hover:bg-[#8B7355]/50' : 'hover:bg-[#1A2C4D]/70';
@endphp

<h1 class="text-3xl font-extrabold text-white mb-6 border-b border-white/20 pb-4 mt-12">
    {{ $slot ?? 'Tabel' }}
</h1>

@if (isset($actions))
    <div class="w-full mb-4">
        {{ $actions }}
    </div>
@endif

<!-- Tabel -->
<div class="{{ $bgTable }} p-2 sm:p-6 rounded-2xl shadow-2xl max-w-full">
    <div class="relative overflow-x-auto w-full">
        <table class="min-w-max w-full text-center {{ $textColor }} border-collapse table-auto whitespace-nowrap">
            <thead>
                <tr class="uppercase text-sm font-bold tracking-wide cursor-pointer">
                    @foreach ($columns as $col)
                        <th class="py-3 px-3 text-base whitespace-nowrap" @if($loop->index > 0 && $loop->index <= count($columns)) wire:click="$emit('sortBy', '{{ \Str::snake($col) }}')" @endif>
                            <div class="flex items-center justify-center space-x-1">
                                <span>{{ $col }}</span>
                                @if($sortField === \Str::snake($col))
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 15l5-5 5 5H5z" />
                                        @else
                                            <path d="M5 5l5 5 5-5H5z" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                    @endforeach

                    @if (!!$rowActions)
                        <th class="py-3 px-3 text-base whitespace-nowrap">
                            Action
                        </th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($rows as $row)
                    <tr class="{{ $hoverBg }} transition duration-200">
                        @foreach ($row as $key => $cell)
                            @if ($key !== 'id' && $key !== 'gambar' && $key !== 'can_edit')
                                <td class="py-3 px-3 text-lg whitespace-nowrap">
                                    {{ $cell }}
                                </td>
                            @endif
                        @endforeach

                        @if ($rowActions)
                            <td class="py-2 px-3 whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <x-dynamic-component :component="$rowActions" :row="$row"
                                        :allowedActions="$rowActionsParams['allowedActions'] ?? []"
                                        :editRoute="$rowActionsParams['editRoute'] ?? null"
                                        :deleteRoute="$rowActionsParams['deleteRoute'] ?? null"
                                        :reportRoute="$rowActionsParams['reportRoute'] ?? null"
                                        :returnRoute="$rowActionsParams['returnRoute'] ?? null"
                                        :resetRoute="$rowActionsParams['resetRoute'] ?? null"
                                        :idField="$rowActionsParams['idField'] ?? 'id'" />
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($rowActions ? 1 : 0) }}" class="py-4 text-center text-gray-300">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pagination)
        <div class="mt-4">
            {{ $pagination->links() }}
        </div>
    @endif
</div>