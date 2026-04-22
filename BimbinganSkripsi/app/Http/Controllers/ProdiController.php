<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index(){
        $data = Prodi::all();
        return view('prodi.index', compact('data'));
    }

    public function create(){
        return view('prodi.create');
    }

    public function store(Request $request){
        $request->validate(['nama_prodi'=>'required']);
        Prodi::create($request->all());
        return redirect()->route('prodi.index');
    }

    public function edit($id){
        $data = Prodi::findOrFail($id);
        return view('prodi.edit', compact('data'));
    }

    public function update(Request $request,$id){
        $data = Prodi::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('prodi.index');
    }

    public function destroy($id){
        Prodi::destroy($id);
        return back();
    }
}
