<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AkunAdminController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'admin_prodi')->with('prodi')->get();
        return view('admin_prodi.index', compact('data'));
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('admin_prodi.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'prodi_id' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_prodi',
            'prodi_id' => $request->prodi_id
        ]);
        return redirect()->route('akun_admin.index');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back();
    }
}