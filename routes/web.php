<?php

use App\Http\Controllers\PembayaranTagihanController;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiSppController;
use App\Http\Controllers\UangDaftarUlangController;
use App\Http\Controllers\TransaksiDuController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Exports\LaporanBulananExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/proses', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::middleware('hak_akses:admin')->group(function () {
        Route::get('/pengguna', [PenggunaController::class, 'index']);
        Route::get('pengguna/insert', [PenggunaController::class, 'insert']);
        Route::post('pengguna/store', [PenggunaController::class, 'store']);
        Route::get('pengguna/edit/{idp}', [PenggunaController::class, 'edit']);
        Route::put('pengguna/update/{idp}', [PenggunaController::class, 'update']);
        Route::delete('pengguna/hapus/{idp}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    });
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/get-siswa/{nis}', [SiswaController::class, 'getSiswa']);
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('siswa/insert', [SiswaController::class, 'insert']);
    Route::post('siswa/stored', [SiswaController::class, 'store']);
    Route::get('siswa/edit/{nis}', [SiswaController::class, 'edit']);
    Route::put('siswa/update/{nis}', [SiswaController::class, 'update']);
    Route::delete('/siswa/{nis}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/naik-kelas', [SiswaController::class, 'naikKelasOtomatis'])->name('naik.kelas');

    Route::get('/kelas', [KelasController::class, 'index']);
    Route::post('/kelas/store', [KelasController::class, 'store']);
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit']);
    Route::put('/kelas/update/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/spp', [SppController::class, 'index']);
    Route::get('spp/insert', [SppController::class, 'insert']);
    Route::post('spp/store', [SppController::class, 'store']);
    Route::get('spp/edit/{idspp}', [SppController::class, 'edit']);
    Route::put('spp/update/{idspp}', [SppController::class, 'update']);
    Route::delete('spp/hapus/{idp}', [SppController::class, 'destroy'])->name('spp.destroy');

    Route::get('/transaksispp', [TransaksiSppController::class, 'index']);
    Route::post('/transaksispp/store', [TransaksiSppController::class, 'store']);
    Route::delete('transaksispp/hapus/{id}', [TransaksiSppController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/daftarulang', [UangDaftarUlangController::class, 'index']);
    Route::post('daftarulang/store', [UangDaftarUlangController::class, 'store']);
    Route::put('daftarulang/update/{idudu}', [UangDaftarUlangController::class, 'update']);
    Route::delete('daftarulang/hapus/{idudu}', [UangDaftarUlangController::class, 'destroy'])->name('daftarulang.destroy');

    Route::get('/transaksidu', [PembayaranTagihanController::class, 'index']);
    Route::post('/transaksidu/store', [PembayaranTagihanController::class, 'store']);
    Route::get('/transaksidu/history', [PembayaranTagihanController::class, 'history']);
    Route::get('/transaksidu/{id}/kuitansi', [PembayaranTagihanController::class, 'kuitansi'])->name('daftarulang.kuitansi');
    Route::get('/transaksidu/{id}/kuitansi/pdf', [PembayaranTagihanController::class, 'kuitansiPdf'])->name('daftarulang.kuitansi.pdf');

    Route::get('/export-bulanan', function (Request $request) {
        return Excel::download(new LaporanBulananExport($request->bulan), "Laporan_Bulanan_{$request->bulan}.xlsx");
    });

    Route::get('/transaksispp/cetak', [TransaksiSPPController::class, 'cetakLaporan'])->name('transaksispp.cetak');
    Route::get('/export-tahunan', [PembayaranTagihanController::class, 'exportTahunan'])->name('export.tahunan');


    Route::get('/riwayattransaksi', [RiwayatTransaksiController::class, 'index']);
});



