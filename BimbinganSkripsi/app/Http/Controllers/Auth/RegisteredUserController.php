<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $prodis = \App\Models\Prodi::all();
        return view('auth.register', compact('prodis'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:dosen,mahasiswa'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'identitas' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'prodi_id' => $request->prodi_id,
        ]);

        if ($request->role === 'mahasiswa') {
            \App\Models\Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->identitas,
                'alamat' => $request->alamat,
            ]);
        } elseif ($request->role === 'dosen') {
            \App\Models\Dosen::create([
                'user_id' => $user->id,
                'nidn' => $request->identitas,
                'alamat' => $request->alamat,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
