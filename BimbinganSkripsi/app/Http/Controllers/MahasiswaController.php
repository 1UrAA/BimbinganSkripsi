<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $data = Mahasiswa::whereHas('user', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })->with('user.prodi')->get();
        } else {
            $data = Mahasiswa::with('user.prodi')->get();
        }
        return view('mahasiswa.index', compact('data'));
    }

    public function create(){
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $prodi = Prodi::where('id', $user->prodi_id)->get();
        } else {
            $prodi = Prodi::all();
        }
        return view('mahasiswa.create', compact('prodi'));
    }

    public function store(Request $request){
        $request->validate([
            'nim'=>'required|unique:mahasiswas',
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'prodi_id'=>'required',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'prodi_id' => $request->prodi_id,
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('mahasiswa.index');
    }

    public function edit($id){
        $data = Mahasiswa::with('user', 'skripsi')->findOrFail($id);
        $userAuth = Auth::user();
        if ($userAuth->role === 'admin_prodi') {
            $prodi = Prodi::where('id', $userAuth->prodi_id)->get();
            if ($data->user->prodi_id != $userAuth->prodi_id) abort(403);
            $dosens = \App\Models\Dosen::whereHas('user', function($q) use ($userAuth) {
                $q->where('prodi_id', $userAuth->prodi_id);
            })->with('user')->get();
        } else {
            $prodi = Prodi::all();
            $dosens = \App\Models\Dosen::with('user')->get();
        }
        return view('mahasiswa.edit', compact('data','prodi', 'dosens'));
    }

    public function update(Request $request,$id){
        $data = Mahasiswa::with('user')->findOrFail($id);

        $request->validate([
            'nim'=>'required|unique:mahasiswas,nim,'.$id,
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$data->user_id,
            'prodi_id'=>'required'
        ]);

        $data->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'prodi_id' => $request->prodi_id,
        ]);
        if($request->password) {
            $data->user->update(['password' => Hash::make($request->password)]);
        }

        $data->update([
            'nim' => $request->nim,
            'alamat' => $request->alamat
        ]);

        if ($request->filled('pembimbing_1_id')) {
            $data->skripsi()->updateOrCreate(
                ['mahasiswa_id' => $data->id],
                ['pembimbing_1_id' => $request->pembimbing_1_id]
            );
        }

        return redirect()->route('mahasiswa.index');
    }

    public function destroy($id){
        $data = Mahasiswa::findOrFail($id);
        User::destroy($data->user_id);
        return back();
    }
}