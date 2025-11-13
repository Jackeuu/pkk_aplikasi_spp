<?php

namespace App\Exports;

use App\Models\PembayaranTagihan;
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

class LaporanBulananExport implements 
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
        return PembayaranTagihan::join('siswa', 'siswa.nis', '=', 'pembayaran_tagihan.nis')
            ->join('tkelas', 'tkelas.idK', '=', 'siswa.idK')
            ->whereMonth('pembayaran_tagihan.created_at', $this->bulan)
            ->select(
                'pembayaran_tagihan.nis',
                'siswa.nama_siswa',
                'tkelas.nama_kelas',
                DB::raw('FORMAT(pembayaran_tagihan.jumlah_tagihan, 0) as jumlah_tagihan'),
                DB::raw('FORMAT(pembayaran_tagihan.bayar, 0) as bayar'),
                DB::raw('FORMAT(pembayaran_tagihan.sisa, 0) as sisa'),
                DB::raw('FORMAT(pembayaran_tagihan.kembalian, 0) as kembalian'),
                'pembayaran_tagihan.status',
                'pembayaran_tagihan.keterangan',
                DB::raw('DATE_FORMAT(pembayaran_tagihan.created_at, "%d-%m-%Y") as tanggal_bayar')
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Total Tagihan (Rp)',
            'Bayar (Rp)',
            'Sisa (Rp)',
            'Kembalian (Rp)',
            'Status',
            'Keterangan',
            'Tanggal Bayar'
        ];
    }

    // ======= Mulai Cell =======
    public function startCell(): string
    {
        return 'A4'; // Header mulai dari baris ke-4
    }

    // ======= Gaya Desain =======
    public function styles(Worksheet $sheet)
    {
        // Judul laporan di baris pertama
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'Laporan Transaksi Bulanan - SD Bina Insan Cendikia');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Warna dan style header tabel
        $headerRange = 'A4:J4';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCE5FF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border untuk seluruh tabel (otomatis menyesuaikan jumlah baris)
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:J' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Rata tengah beberapa kolom
        $sheet->getStyle('A4:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G4:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H4:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Footer waktu cetak
        $footerRow = $lastRow + 2;
        $sheet->mergeCells("A{$footerRow}:J{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", 'Dicetak pada: ' . now()->format('d F Y'));
        $sheet->getStyle("A{$footerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    // Nama sheet
    public function title(): string
    {
        return 'Laporan Bulanan';
    }
}
