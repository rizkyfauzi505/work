<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Menampilkan daftar guru
    public function index()
    {
        $guru = Guru::all();
        return view('dashboard.guru.index', compact('guru'));
    }

    // Tampilkan form tambah guru
    public function create()
    {
        return view('dashboard.guru.create');
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
            'password_plain' => $request->password, // disimpan untuk ditampilkan, meskipun tidak disarankan
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    // Hapus data guru
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}
