<?php

namespace App\Livewire\Services\Export;

use App\Models\Pengadaan;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengadaanExcel
{

    public function exportPengadaan(
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

        $data = Pengadaan::whereBetween('tanggal_pengadaan', [$start, $end])->get();

        return $this->generateExcel(
            $data,
            "laporan-pengadaan-{$periode}"
        );
    }

    public function exportByDateRange(string $start, string $end)
    {
        $data = Pengadaan::whereBetween('tanggal_pengadaan', [
            Carbon::parse($start)->startOfDay(),
            Carbon::parse($end)->endOfDay(),
        ])->get();

        return $this->generateExcel(
            $data,
            'laporan-pengadaan-custom'
        );
    }

    private function generateExcel($data, string $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['Tanggal', 'Nama Alat', 'Vendor', 'Jumlah', 'Harga Satuan', 'Total Harga']
        ]);

        $row = 2;
        foreach ($data as $item) {
            $totalHarga = $item->jumlah * $item->harga;

            $sheet->fromArray([
                Carbon::parse($item->tanggal_pengadaan)->format('Y-m-d'),
                $item->nama_alat,
                $item->vendor ?? '-',
                $item->jumlah,
                $item->harga,
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