<?php

namespace App\Exports;

use App\Models\TransaksiSpp;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithTitle,
    WithCustomStartCell
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanSPPBulananExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    ShouldAutoSize, 
    WithTitle,
    WithCustomStartCell
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return TransaksiSpp::join('siswa', 'siswa.nis', '=', 'ttransaksi.nis')
            ->join('users', 'users.idp', '=', 'ttransaksi.idp')
            ->where('ttransaksi.bulan', $this->bulan)
            ->select(
                'ttransaksi.nis',
                'siswa.nama_siswa',
                'users.nama_pengguna as petugas',
                'ttransaksi.bulan',
                'ttransaksi.tahunBayar',
                DB::raw('DATE_FORMAT(ttransaksi.tanggalBayar, "%d-%m-%Y") as tanggal_bayar')
            )
            ->orderBy('ttransaksi.tanggalBayar', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Petugas',
            'Bulan',
            'Tahun Bayar',
            'Tanggal Bayar'
        ];
    }

    // Mulai dari baris ke-4 agar ada ruang untuk judul
    public function startCell(): string
    {
        return 'A4';
    }

    public function styles(Worksheet $sheet)
    {
        // === Judul Besar ===
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'Laporan Pembayaran SPP Bulanan - SD Bina Insan Cendikia');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // === Header Tabel ===
        $headerRange = 'A4:F4';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCE5FF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // === Border Semua Cell ===
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:F' . $lastRow)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // === Rata Tengah Kolom ===
        $sheet->getStyle('A4:C' . $lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D4:F' . $lastRow)
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // === Footer ===
        $footerRow = $lastRow + 2;
        $sheet->mergeCells("A{$footerRow}:F{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", 'Dicetak pada: ' . now()->format('d F Y'));
        $sheet->getStyle("A{$footerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    public function title(): string
    {
        return 'Laporan SPP Bulanan';
    }
}
