<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    // Tampilkan semua data permintaan
    public function index()
    {
        $permintaan = Permintaan::all();
        return view('permintaan.index', compact('permintaan'));
    }

    // Tampilkan detail permintaan tertentu
    public function show($id)
    {
        $permintaan = Permintaan::findOrFail($id);
        return view('permintaan.show', compact('permintaan'));
    }
    public function status($id)
    {
         $permintaan = Permintaan::findOrFail($id);
         return view('permintaan.status', compact('permintaan'));
    }

    // Ubah status permintaan
    public function updateStatus($id, Request $request)
    {
        $permintaan = Permintaan::findOrFail($id);
        $permintaan->status = $request->status;
        $permintaan->save();

        return redirect()->route('permintaan.index')->with('success', 'Status permintaan berhasil diupdate.');
    }
}
