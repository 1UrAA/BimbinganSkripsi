<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sidang;

class AdminSidangController extends Controller
{
    public function setJadwal(Request $request){
    $sidang = Sidang::find($request->sidang_id);

    $sidang->update([
        'tanggal'=>$request->tanggal,
        'jam'=>$request->jam,
        'ruangan_id'=>$request->ruangan_id,
        'status'=>'terjadwal'
    ]);

    return back();
    }
}