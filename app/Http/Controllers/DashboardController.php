<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\TransaksiSpp;
use App\Models\PembayaranTagihan;
use App\Models\ActivityLog; // tambahkan ini
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas = Kelas::count();
        $totalUsers = User::count();
        $totalSiswa = Siswa::count();
        $totalTransaksispp = TransaksiSpp::count();

        $logs = ActivityLog::latest()->take(5)->get();

        $tahunSekarang = Carbon::now()->year;

        // === DATA UNTUK GRAFIK ===
        $bulan = collect(range(1, 12))->map(function ($m) {
            return Carbon::create()->month($m)->translatedFormat('F');
        });

        // Hitung transaksi SPP per bulan (tahun berjalan)
        $dataSpp = collect(range(1, 12))->map(function ($m) use ($tahunSekarang) {
            return TransaksiSpp::whereYear('tanggalBayar', $tahunSekarang)
                ->whereMonth('tanggalBayar', $m)
                ->count();
        });

        // Hitung transaksi daftar ulang per bulan (tahun berjalan)
        $dataDaftarUlang = collect(range(1, 12))->map(function ($m) use ($tahunSekarang) {
            return PembayaranTagihan::whereYear('created_at', $tahunSekarang)
                ->whereMonth('created_at', $m)
                ->count();
        });

        return view('dashboard', compact(
            'totalKelas',
            'totalUsers',
            'totalSiswa',
            'totalTransaksispp',
            'logs',
            'bulan',
            'dataSpp',
            'dataDaftarUlang'
        ));
    }


}