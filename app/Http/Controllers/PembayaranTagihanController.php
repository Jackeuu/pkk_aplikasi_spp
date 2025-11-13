<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PembayaranTagihan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranTagihanController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::join('siswa', 'siswa.nis', '=', 'ttagihan.nis')->join('tkelas', 'tkelas.idK', '=', 'siswa.idk')->get();
        $siswas = DB::table('siswa')->select('nis', 'nama_siswa')->get();
        return view('transaksidu.index', compact('tagihan', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'tagihan' => 'required|numeric|min:1',
            'bayar' => 'required|int|min:1',
            'sisa' => 'required',
            'kembali' => 'required'
        ]);

        $nis = $request->nis;
        $no_kuintasi = 'TGH00' . now()->format('H-i-s-d-M-Y') . '-' . $nis;

        if ($request->sisa > 0 && $request->kembali <= 0) {
            $status = 'Belum Lunas';
        } else if ($request->sisa <= 0 && $request->kembali >= 0) {
            $status = 'Lunas';
        }

        PembayaranTagihan::create([
            'nis' => $nis,
            'tanggal_bayar' => now(),
            'jumlah_tagihan' => $request->tagihan,
            'bayar' => $request->bayar,
            'sisa' => $request->sisa,
            'kembalian' => $request->kembali,
            'no_kuitansi' => $no_kuintasi,
            'status' => $status,
            'keterangan' => $request->keterangan,
        ]);

        Tagihan::where('nis', $nis)->update([
            'jumlah' => $request->sisa,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil disimpan');
    }

    public function history()
    {
        $data = PembayaranTagihan::join('siswa', 'siswa.nis', '=', 'pembayaran_tagihan.nis')
            ->join('tuangdaftarulang', 'tuangdaftarulang.idudu', '=', 'siswa.idudu', 'Left')->get();


        return view('riwayattransaksi.index', compact('data'));
    }

    public function kuitansi($id)
    {
        $data = PembayaranTagihan::join('siswa', 'siswa.nis', '=', 'pembayaran_tagihan.nis')
            ->join('tkelas', 'tkelas.idk', '=', 'siswa.idk')
            ->where('pembayaran_tagihan.id', $id)
            ->select('pembayaran_tagihan.*', 'siswa.nama_siswa', 'siswa.nis', 'tkelas.nama_kelas')
            ->firstOrFail();

        return view('transaksidu.kuitansi', compact('data'));
    }

    public function kuitansiPdf($id)
    {
        $data = PembayaranTagihan::join('siswa', 'siswa.nis', '=', 'pembayaran_tagihan.nis')
            ->join('tkelas', 'tkelas.idk', '=', 'siswa.idk')
            ->where('pembayaran_tagihan.id', $id)
            ->select('pembayaran_tagihan.*', 'siswa.nama_siswa', 'siswa.nis', 'tkelas.nama_kelas')
            ->firstOrFail();

        $pdf = Pdf::loadView('transaksidu.kuitansi_pdf', compact('data'))->setPaper('A5', 'portrait');
        return $pdf->download('kuitansi-daftar-ulang-' . $data->id . '.pdf');
    }
}
