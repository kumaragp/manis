@props(['columns', 'rows', 'rowActions' => null, 'rowActionsParams' => []])

<h1 class="text-3xl font-extrabold text-white mb-6 border-b border-white/20 pb-4">
    {{ $slot ?? 'Tabel' }}
</h1>

@if (isset($actions))
    <div class="flex justify-end mb-4">
        {{ $actions }}
    </div>
@endif

<div class="bg-[#0A3B65] p-6 rounded-2xl shadow-2xl">
    <div class="overflow-x-auto">
        <table class="min-w-full text-center text-white border-collapse">
            <thead>
                <tr class="uppercase text-sm border-b border-[#2A3F68] font-bold tracking-wide">
                    @foreach ($columns as $col)
                        <th class="py-4 px-3 text-base">{{ $col }}</th>
                    @endforeach

                    @if (!!$rowActions)
                        <th class="py-4 px-3 text-base">Action</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-[#2A3F68]">
                @foreach ($rows as $row)
                    <tr class="hover:bg-[#1A2C4D]/70 transition duration-200">
                        {{-- Cells --}}
                        @foreach ($row as $cell)
                            <td class="py-3 text-lg">{{ $cell }}</td>
                        @endforeach

                        {{-- Row Actions --}}
                        @if ($rowActions)
                            <td class="py-3 flex justify-center">
                                <x-dynamic-component :component="$rowActions" :row="$row"
                                    :allowedActions="$rowActionsParams['allowedActions'] ?? []"
                                    :editRoute="$rowActionsParams['editRoute'] ?? null"
                                    :deleteRoute="$rowActionsParams['deleteRoute'] ?? null"
                                    :idField="$rowActionsParams['idField'] ?? 0" />
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>