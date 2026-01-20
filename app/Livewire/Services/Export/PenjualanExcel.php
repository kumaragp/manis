<?php

namespace App\Livewire\Services\Export;

use App\Models\Penjualan;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenjualanExcel
{
    public function exportPenjualan(
        string $periode,
        int $tahun,
        ?int $bulan = null,
        ?int $minggu = null
    ) {
        if ($periode === 'tahun') {
            $start = Carbon::create($tahun)->startOfYear();
            $end   = Carbon::create($tahun)->endOfYear();

        } elseif ($periode === 'bulan') {
            $start = Carbon::create($tahun, $bulan)->startOfMonth();
            $end   = Carbon::create($tahun, $bulan)->endOfMonth();

        } else {
            $start = Carbon::create($tahun, $bulan)
                ->startOfMonth()
                ->addWeeks($minggu - 1)
                ->startOfWeek();

            $end = $start->copy()->endOfWeek();
        }

        $data = Penjualan::with('alat')
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->get();

        return $this->generateExcel(
            $data,
            "laporan-penjualan-{$periode}"
        );
    }

    public function exportByDateRange(string $start, string $end)
    {
        $data = Penjualan::with('alat')
            ->whereBetween('tanggal_penjualan', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay(),
            ])
            ->get();

        return $this->generateExcel(
            $data,
            'laporan-penjualan-custom'
        );
    }

    private function generateExcel($data, string $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['Tanggal', 'Nama Alat', 'Pembeli', 'Jumlah', 'Harga Satuan', 'Total Harga']
        ]);

        $row = 2;
        foreach ($data as $item) {
            $totalHarga = $item->jumlah * $item->harga_jual;

            $sheet->fromArray([
                Carbon::parse($item->tanggal_penjualan)->format('Y-m-d'),
                $item->alat->nama_alat ?? '-',
                $item->customer,
                $item->jumlah,
                $item->harga_jual,
                $totalHarga,
            ], null, "A{$row}");

            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, "{$filename}.xlsx");
    }
}