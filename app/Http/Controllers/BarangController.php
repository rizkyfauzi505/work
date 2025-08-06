<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

class BarangController extends Controller
{
    // ✅ Form Tambah Barang
    public function create()
    {
        return view('dashboard.barang.create');
    }

    // ✅ Simpan Barang ke Database
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk_barang' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'asal_usul' => 'required|string|max:255',
            'harga_barang' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'merk_barang' => $request->merk_barang,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'asal_usul' => $request->asal_usul,
            'harga_barang' => $request->harga_barang,
            'stok' => $request->stok,
        ]);

        return redirect()->route('barang.baru')->with('success', 'Data barang berhasil ditambahkan!');
    }

    // ✅ Barang Baru (30 Hari Terakhir)
    public function barangBaru()
    {
        $tanggalBatas = Carbon::now()->subDays(30);
        $barang = Barang::where('tanggal_pembelian', '>=', $tanggalBatas)->get();

        return view('dashboard.barang.baru', compact('barang'));
    }

    // ✅ Semua Stok Barang
    public function allStok()
    {
        $barang = Barang::all();

        return view('dashboard.barang.stok', compact('barang'));
    }
}
