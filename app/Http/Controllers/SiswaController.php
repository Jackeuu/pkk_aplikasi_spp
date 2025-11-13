<?php

namespace App\Http\Controllers;

use App\Models\PembayaranTagihan;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\UangDaftarUlang;
use App\Models\Tagihan;
use App\Models\TransaksiDu;
use App\Models\Spp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('siswa.index', compact('siswa'));
    }

    public function insert()
    {
        return view('siswa.insert');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'idk' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
        ]);

        $nis = $request->nis;

        if (in_array($request->idk, [1, 2])) {
            $idspp = 1; // Rp.400.000
        } else if ($request->idk == 3) {
            $idspp = 2; // Rp.350.000
        } else if (in_array($request->idk, [4, 5, 6])) {
            $idspp = 3; // Rp.375.000
        }

        if (in_array($request->idk, [1, 2])) {
            $idUang = 1; // Rp.3.000.000
        } else if ($request->idk == 3) {
            $idUang = 2; // Rp.2.950.000
        } else if (in_array($request->idk, [4, 5, 6])) {
            $idUang = 3; // Rp.2.975.000
        }

        DB::table('siswa')->insert([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'idk' => $request->idk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'idspp' => $idspp,
            'idudu' => $idUang == 0 ? null : $idUang,
        ]);

        $uang = UangDaftarUlang::find($idUang)->nominal_du;

        Tagihan::create([
            'nis' => $nis,
            'jumlah' => $uang,
            'status' => 'Belum lunas',
        ]);

        // Catat log aktivitas
        ActivityLog::create([
            'user' => Auth::user()->nama_pengguna ?? 'System',
            'aksi' => 'Menambahkan data siswa bernama ' . $request->nama_siswa,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        DB::table('siswa')->where('nis', $request->nis)->update([
            'nama_siswa' => $request->nama_siswa,
            'idk' => $request->idk,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'idspp' => $request->idspp,
        ]);
        return redirect()->back()->with('success', 'Siswa berhasil diedit!');
    }

    public function destroy($nis)
    {
        DB::table('siswa')->where('nis', $nis)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }

    public function getSiswa($nis)
    {
        $siswa = Siswa::join('tspp', 'siswa.idspp', '=', 'tspp.idspp')
            ->join('tuangdaftarulang', 'tuangdaftarulang.idudu', '=', 'siswa.idudu')
            ->select('siswa.nama_siswa', 'siswa.idk', 'tspp.nominal', 'tuangdaftarulang.nominal_du')
            ->where('siswa.nis', $nis)
            ->first();

        if ($siswa) {
            return response()->json([
                'success' => true,
                'data' => $siswa
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ]);
        }
    }

    public function naikKelasOtomatis()
    {
        $siswa = Siswa::all();

        foreach ($siswa as $s) {
            if ($s->idk < 6) {
                // Naikkan kelas
                $s->idk += 1;

                // Atur SPP Baru
                if (in_array($s->idk, [1, 2])) {
                    $s->idspp = 1;
                } elseif ($s->idk == 3) {
                    $s->idspp = 2;
                } elseif (in_array($s->idk, [4, 5, 6])) {
                    $s->idspp = 3;
                }

                // Tentukan ID Uang DU berdasarkan kelas baru
                if ($s->idk == 2) {
                    $idUang = 1;
                } elseif ($s->idk == 3) {
                    $idUang = 2;
                } elseif (in_array($s->idk, [4, 5, 6])) {
                    $idUang = 3;
                } else {
                    $idUang = null;
                }

                // Update ID Uang daftar ulang di tabel siswa
                $s->idudu = $idUang;
                $s->save();

                // Jika memiliki uang daftar ulang
                if ($idUang) {
                    $uang = UangDaftarUlang::find($idUang);

                    // Reset / Update Tagihan Daftar Ulang
                    $tagihan = Tagihan::where('nis', $s->nis)->first();

                    $sisa_tagihan = PembayaranTagihan::where('nis', $s->nis)->orderBy('id', 'DESC')->first();

                    if ($sisa_tagihan->sisa != 0) {
                        $tagihan->update([
                            'jumlah' => $uang->nominal_du + $sisa_tagihan->sisa,
                            'status' => 'Belum lunas', // <-- Reset otomatis
                        ]);
                    } else if ($sisa_tagihan == 0) {
                        Tagihan::create([
                            'nis' => $s->nis,
                            'jumlah' => $uang->nominal_du,
                            'status' => 'Belum lunas',
                        ]);
                    }
                }
            } else {
                // kelas 6 -> pindah ke alumni atau delete
                $s->delete();
            }
        }

        return back()->with('success', 'Kenaikan kelas berhasil diproses!');
    }

}