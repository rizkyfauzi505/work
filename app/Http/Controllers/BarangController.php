<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

class BarangController extends Controller
{
    /**
     * ✅ Tampilkan Form Tambah Barang
     */
    public function create()
    {
        return view('dashboard.barang.create');
    }

    /**
     * ✅ Simpan Barang ke Database
     */
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

        return redirect()->route('barang.create')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * ✅ Tampilkan Barang Baru (7 Hari Terakhir)
     */
    public function barangBaru()
    {
        $tanggalBatas = Carbon::now()->subDays(7);

        $barang = Barang::where('tanggal_pembelian', '>=', $tanggalBatas)
                        ->orderBy('tanggal_pembelian', 'desc')
                        ->get();

        return view('dashboard.barang.baru', compact('barang'));
    }

    /**
     * ✅ Tampilkan Semua Stok Barang + Pencarian
     */
    public function allStok(Request $request)
    {
        $query = Barang::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_barang', 'like', "%$search%");
        }

        $barang = $query->get();

        return view('dashboard.barang.stok', compact('barang'));
    }

    /**
     * ✅ Hapus Barang
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.stok')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * ✅ Export Laporan ke PDF
     */
    public function exportPDF()
    {
        $barang = Barang::all();
        $pdf = Pdf::loadView('dashboard.barang.laporan', compact('barang'));
        return $pdf->download('laporan-barang.pdf');
    }
}
