<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Guru;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,guru',
        ]);

        if ($request->role === 'admin') {
            $admin = Admin::where('nama_admin', $request->nama)->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                Session::put('admin', $admin);
                return redirect()->route('dashboard.admin');
            }
        } elseif ($request->role === 'guru') {
            $guru = Guru::where('nama', $request->nama)->first();

            if ($guru && Hash::check($request->password, $guru->password)) {
                Session::put('guru', $guru);
                return redirect()->route('dashboard.guru');
            }
        }

        return back()->with('error', 'Nama atau password salah.');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi umum
        $rules = [
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru',
        ];

        // NIP wajib untuk keduanya
        $rules['nip'] = 'required|string|max:255';

        $request->validate($rules);

        // Simpan sesuai role
        if ($request->role === 'admin') {
            Admin::create([
                'nip' => $request->nip,
                'nama_admin' => $request->nama,
                'password' => Hash::make($request->password),
                  'password_plain' => $request->password
            ]);
        } elseif ($request->role === 'guru') {
            Guru::create([
                'nip' => $request->nip,
                'nama_guru' => $request->nama,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }

    // Logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
