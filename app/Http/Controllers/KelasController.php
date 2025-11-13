<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));  
    }

    public function store(Request $request){
        DB::table('tkelas')->insert([
            'nama_kelas' => $request -> nama_kelas,
        ]);
        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $idk){
        DB::table('tkelas')->where('idK', $idk)->update([
            'nama_kelas' => $request -> nama_kelas,
        ]);
        return redirect()->back()->with('success', 'Kelas berhasil diedit!');
    }

    public function destroy($idk){
        DB::table('tkelas')->where('idK', $idk)->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }
}
