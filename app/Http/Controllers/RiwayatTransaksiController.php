<?php

namespace App\Http\Controllers;

use App\Models\PembayaranTagihan;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $data = PembayaranTagihan::select(
            'pembayaran_tagihan.*',
            'siswa.nama_siswa',
            'siswa.nis'
        )
            ->join('siswa', 'siswa.nis', '=', 'pembayaran_tagihan.nis')
            ->orderBy('pembayaran_tagihan.created_at', 'desc')
            ->get();

        return view('riwayattransaksi.index', compact('data'));
    }
}
