<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $admin = Session::get('admin');

        if ($admin) {
            $totalStok = Barang::count();

            $tanggalBatas = Carbon::now()->subDays(30);
            $barangBaru = Barang::where('tanggal_pembelian', '>=', $tanggalBatas)->count();

            return view('dashboard.admin', compact('admin', 'totalStok', 'barangBaru'));
        }

        return redirect('/login')->with('error', 'Akses ditolak.');
    }

    public function guru()
    {
        $guru = Session::get('guru');

        if ($guru) {
            return view('dashboard.guru', compact('guru'));
        }

        return redirect('/login')->with('error', 'Akses ditolak.');
    }
}
