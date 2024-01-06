<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaKab;

class DropDownController extends Controller
{
    public function fatchState(Request $request){
        $data['kota_kab'] = KotaKab::where('kode_prov', $request->kode_prov)->get(['kode_kota_kab', 'nama_kota_kab']);
        return response()->json($data);
    }
}
