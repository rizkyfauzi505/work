<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Barang;
use App\Models\Admin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $admin = Session::get('admin');
        if (!$admin) {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        $totalStok = Barang::count();
        $tanggalBatas = Carbon::now()->subDays(30);
        $barangBaru = Barang::where('tanggal_pembelian', '>=', $tanggalBatas)->count();

        return view('dashboard.admin', compact('admin', 'totalStok', 'barangBaru'));
    }

    public function guru()
    {
        $guru = Session::get('guru');
        if (!$guru) {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        return view('dashboard.guru', compact('guru'));
    }

    public function updateProfil(Request $request)
{
    $adminSession = Session::get('admin');
    if (!$adminSession) {
        // Kalau AJAX, balikin JSON error, kalau bukan redirect biasa
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }
        return redirect('/login')->with('error', 'Akses ditolak.');
    }

    $admin = Admin::find($adminSession->id_admin);
    if (!$admin) {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Data admin tidak ditemukan.'], 404);
        }
        return redirect()->back()->with('error', 'Data admin tidak ditemukan.');
    }

    $validatedData = $request->validate([
        'nama_admin' => 'required|string|max:100',
        'password'   => 'nullable|string|min:6',
        'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $admin->nama_admin = $validatedData['nama_admin'];

    if (!empty($validatedData['password'])) {
        $admin->password = bcrypt($validatedData['password']);
        $admin->password_plain = $request->password; // simpan plaintext
    }

    if ($request->hasFile('foto')) {
        if ($admin->foto && Storage::disk('public')->exists($admin->foto)) {
            Storage::disk('public')->delete($admin->foto);
        }
        $fotoPath = $request->file('foto')->store('foto_admin', 'public');
        $admin->foto = $fotoPath;
    }

    $admin->save();
    Session::put('admin', $admin);

    // Respon JSON jika AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
        ]);
    }

    // Kalau bukan AJAX redirect biasa
    return redirect()->route('dashboard.admin')->with('success', 'Profil berhasil diperbarui!');
}

}
