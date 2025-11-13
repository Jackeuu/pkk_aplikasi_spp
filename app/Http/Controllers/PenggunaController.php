<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User    ::all();
        return view('pengguna.index', compact('pengguna'));
    }
    public function insert(){
        return view('pengguna.insert');
    }

    public function store(Request $request){
        DB::table('tpengguna')->insert([
            'idp' => $request -> idp,
            'nama_pengguna' => $request -> nama_pengguna,
            'no_telp' => $request -> no_telp,
            'email' => $request -> email,
            'hak_akses' => $request -> hak_akses,
            'password' => bcrypt($request->password),
        ]);
        return redirect('/pengguna');
    }
    public function edit($idp){
        $pengguna = DB::table('tpengguna')->where('idp', $idp)->get();
        return view('pengguna.edit', ['pengguna' => $pengguna]);
    }

    public function update(Request $request){
        DB::table('tpengguna')->where('idp', $request->idp)->update([
            'idp' => $request -> idp,
            'nama_pengguna' => $request -> nama_pengguna,
            'no_telp' => $request -> no_telp,
            'email' => $request -> email,
            'hak_akses' => $request -> hak_akses,
        ]);
        return redirect('/pengguna');
    }

    public function destroy($idp)
    {
        DB::table('users')->where('idp', $idp)->delete();
        return redirect()->back()->with('success', 'Data pengguna berhasil dihapus');
    }
}
