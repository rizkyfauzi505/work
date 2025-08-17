<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // ✅ jangan lupa import Session

class GuruController extends Controller
{
    // Menampilkan daftar guru
    public function index()
    {
        $admin = Session::get('admin'); // ✅ ambil data admin dari session
        $guru = Guru::all();
        return view('dashboard.guru.index', compact('guru', 'admin'));
    }

    // Tampilkan form tambah guru
    public function create()
    {
        $admin = Session::get('admin'); // ✅ kirim juga admin
        return view('dashboard.guru.create', compact('admin'));
    }

    // Simpan data guru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama_guru' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password, // ⚠️ sebaiknya jangan simpan plain password (kurang aman)
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    // Hapus data guru
    public function destroy($id)
    {
        $admin = Session::get('admin'); // ✅ biar foto profil konsisten setelah hapus
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}
