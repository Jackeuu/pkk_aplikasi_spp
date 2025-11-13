<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Spp;

class SppController extends Controller
{
    public function index()
    {
        $spp = Spp::all();
        return view('spp.index', compact('spp'));
    }

    public function store(Request $request){
        Spp::create([
            'nominal' => $request->nominal,
        ]);
        return redirect()->back()->with('success', 'Data SPP berhasil ditambahkan!');
    }

    public function update(Request $request){
        DB::table('tspp')->where('idspp', $request->idspp)->update([
            'nominal' => $request -> nominal,
        ]);
        return redirect()->back()->with('success', 'Data SPP berhasil diedit!');
    }

    public function destroy($idspp)
    {
        DB::table('tspp')->where('idspp', $idspp)->delete();
        return redirect()->back()->with('success', 'Data spp berhasil dihapus');
    }
}
