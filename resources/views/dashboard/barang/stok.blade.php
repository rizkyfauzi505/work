@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  All Stok Barang
</div>

<!-- 🔍 Search Box -->
<form method="GET" action="{{ route('barang.stok') }}" class="search-form" style="margin-bottom: 16px; display: flex; align-items: center; gap: 6px;">
  <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" style="padding: 6px 10px; border-radius: 16px; border: 1px solid #ccc; font-size: 12px;">
  <button type="submit" style="background: none; border: none; cursor: pointer;">
    <i class="fas fa-search" style="font-size: 14px; color: #3b7dd8;"></i>
  </button>
</form>

<!-- 🧾 Tombol Unduh -->
<a href="{{ route('barang.export.pdf') }}" class="btn-simpan" style="margin-bottom: 12px; display: inline-block;">
  <i class="fas fa-file-pdf"></i> Unduh Laporan PDF
</a>

<!-- 📋 Tabel Data -->
<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Merk</th>
        <th>Tanggal Pembelian</th>
        <th>Asal Usul</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($barang as $index => $b)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $b->nama_barang }}</td>
        <td>{{ $b->merk_barang }}</td>
        <td>{{ $b->tanggal_pembelian }}</td>
        <td>{{ $b->asal_usul }}</td>
        <td>Rp{{ number_format($b->harga_barang, 0, ',', '.') }}</td>
        <td>{{ $b->stok }}</td>
        <td>
          <form action="{{ route('barang.destroy', $b->id_barang) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-hapus-barang" style="background: none; border: none; color: red; cursor: pointer;">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align: center;">Tidak ada data barang.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- ✅ SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>  
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session("success") }}',
      showConfirmButton: false,
      timer: 2000
    });
</script>    
@endif

<script>  
// ✅ Konfirmasi sebelum hapus
document.querySelectorAll('.btn-hapus-barang').forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Yakin ingin menghapus barang ini?',
      text: "Data tidak dapat dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        this.closest('form').submit();
      }
    });
  });
});
</script>
@endsection
