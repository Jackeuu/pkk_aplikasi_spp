<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ],[
            'required' => ':attribute tidak boleh kosong.',
            'email.email' => 'Email yang anda masukkan tidak valid.',
        ]);

        if(Auth::attempt($credentials,$request->filled('remember'))){
            $request->session()->regenerate();
            //redirect ke dashvoard
            return redirect()->intended(route('dashboard'));
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    //registir dibawah ini
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::create([
            'nama_pengguna' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hak_akses' => $request->role,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
