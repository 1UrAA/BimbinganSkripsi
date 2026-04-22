<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $data = Dosen::whereHas('user', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })->with('user.prodi')->get();
        } else {
            $data = Dosen::with('user.prodi')->get();
        }
        return view('dosen.index', compact('data'));
    }

    public function create(){
        $user = Auth::user();
        if ($user->role === 'admin_prodi') {
            $prodi = Prodi::where('id', $user->prodi_id)->get();
        } else {
            $prodi = Prodi::all();
        }
        return view('dosen.create', compact('prodi'));
    }

    public function store(Request $request){
        $request->validate([
            'nidn'=>'required|unique:dosens',
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'prodi_id'=>'required',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
            'prodi_id' => $request->prodi_id,
        ]);

        Dosen::create([
            'user_id' => $user->id,
            'nidn' => $request->nidn,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('dosen.index');
    }

    public function edit($id){
        $data = Dosen::with('user')->findOrFail($id);
        $userAuth = Auth::user();
        if ($userAuth->role === 'admin_prodi') {
            $prodi = Prodi::where('id', $userAuth->prodi_id)->get();
            if ($data->user->prodi_id != $userAuth->prodi_id) abort(403);
        } else {
            $prodi = Prodi::all();
        }
        return view('dosen.edit', compact('data','prodi'));
    }

    public function update(Request $request,$id){
        $data = Dosen::with('user')->findOrFail($id);

        $request->validate([
            'nidn'=>'required|unique:dosens,nidn,'.$id,
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
            'nidn' => $request->nidn,
            'alamat' => $request->alamat
        ]);
        return redirect()->route('dosen.index');
    }

    public function destroy($id){
        $data = Dosen::findOrFail($id);
        User::destroy($data->user_id);
        return back();
    }
}