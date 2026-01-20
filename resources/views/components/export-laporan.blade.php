@props(['periode', 'tahun', 'bulan', 'minggu', 'exportMode'])

<div x-data="{ open: false }" class="relative">

    <x-action-button
        label="Export"
        icon="fa-file-excel"
        @click="open = !open"
        class="bg-[#55A0FF] hover:bg-[#3B8FE0] text-[#0A3B65]"
    />

    <div
        x-show="open" x-cloak
        @click.outside="open = false"
        x-transition
        class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl p-4 z-50"
    >
        <h3 class="font-semibold text-gray-700 mb-4">
            Export Laporan
        </h3>

        <div class="mb-3">
            <label class="text-sm text-gray-600">Mode Export</label>
            <select wire:model.live="exportMode"
                class="w-full px-3 py-2 rounded-lg border">
                <option value="preset">Preset</option>
                <option value="custom">Custom Tanggal</option>
            </select>
        </div>

        @if ($exportMode === 'preset')
            <div class="mb-2">
                <label class="text-sm text-gray-600">Periode</label>
                <select wire:model.live="periode"
                    class="w-full px-3 py-2 rounded-lg border">
                    <option value="tahun">Tahunan</option>
                    <option value="bulan">Bulanan</option>
                    <option value="minggu">Mingguan</option>
                </select>
            </div>

            <div class="mb-2">
                <label class="text-sm text-gray-600">Tahun</label>
                <select wire:model.live="tahun"
                    class="w-full px-3 py-2 rounded-lg border">
                    @for ($y = now()->year; $y >= now()->year - 4; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>

            @if ($periode !== 'tahun')
                <div class="mb-2">
                    <label class="text-sm text-gray-600">Bulan</label>
                    <select wire:model.live="bulan"
                        class="w-full px-3 py-2 rounded-lg border">
                        @foreach ([1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'] as $num => $name)
                            <option value="{{ $num }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($periode === 'minggu')
                <div class="mb-3">
                    <label class="text-sm text-gray-600">Minggu</label>
                    <select wire:model.live="minggu"
                        class="w-full px-3 py-2 rounded-lg border">
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">Minggu {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            @endif
        @endif

        @if ($exportMode === 'custom')
            <div class="mb-2">
                <label class="text-sm text-gray-600">Tanggal Mulai</label>
                <input type="date"
                    wire:model.live="tanggalMulai"
                    class="w-full px-3 py-2 rounded-lg border">
            </div>

            <div class="mb-3">
                <label class="text-sm text-gray-600">Tanggal Selesai</label>
                <input type="date"
                    wire:model.live="tanggalSelesai"
                    class="w-full px-3 py-2 rounded-lg border">
            </div>
        @endif

        <button wire:click="exportExcel"
            class="w-full bg-[#55A0FF] hover:bg-[#3B8FE0]
            text-[#0A3B65] py-2 rounded-lg font-semibold">
            Export Excel
        </button>
    </div>
</div>