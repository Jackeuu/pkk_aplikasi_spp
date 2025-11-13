<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSpp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanSPPBulananExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ActivityLog;

class TransaksiSppController extends Controller
{
    public function index()
    {
        $transaksiSpp = TransaksiSpp::join('users', 'users.idp', '=', 'ttransaksi.idp')->get();
        $bulans = DB::select('SELECT * FROM vbulan');
        $siswas = DB::table('siswa')->select('nis', 'nama_siswa')->get();
        return view('transaksispp.index', compact('transaksiSpp', 'bulans', 'siswas'));
    }

    // public function create()
    // {
    //     $siswas = DB::table('siswa')->select('nis', 'nama_siswa')->get();
    //     $bulans = DB::table('vbulan')->get();
    //     return view('transaksispp.create', compact('siswas', 'bulans'));
    // }


    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|numeric',
            'bulan' => 'required|array',
        ]);

        $cekBulan = TransaksiSpp::where('bulan', $request->bulan)->where('nis', $request->nis)->get();
        if (!$cekBulan->isEmpty()) {
            return redirect()->back()->with('error', 'Bulan yang dipilih sudah dibayar!');
        }

        foreach ($request->bulan as $bulan) {
            $tanggalBayar = now()->setMonth($bulan)->startOfMonth(); // tanggal 1 di bulan terpilih

            TransaksiSpp::create([
                'nis' => $request->nis,
                'tanggalBayar' => $tanggalBayar,
                'bulan' => $bulan,
                'tahunBayar' => now()->format('Y'),
                'idp' => Auth::user()->idp,
            ]);
        }


        // untuk transaksi
        ActivityLog::create([
            'user' => Auth::user()->nama_pengguna ?? 'System',
            'aksi' => 'Melakukan transaksi SPP untuk siswa ' . $request->nama_siswa
        ]);
        return redirect('/transaksispp')->with('success', 'Transaksi Berhasil!');
    }

    public function destroy($id)
    {
        DB::table('ttransaksi')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus');
    }

    public function cetakLaporan(Request $request)
    {
        $bulan = $request->bulan; // dropdown dari view
        return Excel::download(new LaporanSPPBulananExport($bulan), 'Laporan-SPP-' . $bulan . '.xlsx');
    }
}