@props(['columns', 'rows', 'rowActions' => null, 'rowActionsParams' => []])

@php
    $role = Auth::user()->role ?? 'admin';

    $bgTable = $role === 'karyawan' ? 'bg-[#746447]' : 'bg-[#0A3B65]';
    $textColor = $role === 'karyawan' ? 'text-[#ffffff]' : 'text-white';
    $borderColor = $role === 'karyawan' ? 'border-[#8B7355]' : 'border-[#2A3F68]';
    $hoverBg = $role === 'karyawan' ? 'hover:bg-[#8B7355]/50' : 'hover:bg-[#1A2C4D]/70';
@endphp

<h1 class="text-3xl font-extrabold text-white mb-6 border-b border-white/20 pb-4 pt-16">
    {{ $slot ?? 'Tabel' }}
</h1>

@if (isset($actions))
    <div class="flex justify-end mb-4">
        {{ $actions }}
    </div>
@endif

<!-- Tabel -->
<div class="{{ $bgTable }} p-2 sm:p-6 rounded-2xl shadow-2xl max-w-full">

    <!-- Wrapper -->
    <div class="relative overflow-x-auto w-full">

        <table class="min-w-max w-full text-center {{ $textColor }}
                   border-collapse table-auto whitespace-nowrap">

            <thead>
                <tr class="uppercase text-sm font-bold tracking-wide">
                    @foreach ($columns as $col)
                        <th class="py-3 px-3 text-base whitespace-nowrap">
                            {{ $col }}
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
                @foreach ($rows as $row)
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
                @endforeach
            </tbody>

        </table>
    </div>
</div>