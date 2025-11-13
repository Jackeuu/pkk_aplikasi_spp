<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\UangDaftarUlang;

class UangDaftarUlangController extends Controller
{
    public function index(){
        $daftarulang = UangDaftarUlang::all();
        return view('daftarulang.index', compact('daftarulang'));
    }

    public function store(Request $request){
        DB::table('tuangdaftarulang')->insert([
            'idudu' => $request -> idudu,
            'nominal_du' => $request -> nominal,
            'tahun_ajaran' => $request -> tahun_ajaran,
        ]);
        return redirect()->back()->with('success', 'Data Uang Daftar Ulang berhasil ditambahkan!');
    }
    public function update(Request $request){
        DB::table('tuangdaftarulang')->where('idudu', $request->idudu)->update([
            'idudu' => $request -> idudu,
            'nominal_du' => $request -> nominal,
            'tahun_ajaran' => $request -> tahun_ajaran,
        ]);
        return redirect()->back()->with('success', 'Data Uang Daftar Ulang berhasil diedit!');
    }

    public function destroy($idudu)
    {
        DB::table('tuangdaftarulang')->where('idudu', $idudu)->delete();
        return redirect()->back()->with('success', 'Data Uang Daftar Ulang berhasil dihapus');
    }
}
