@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Tambah Barang
</div>

<div class="form-wrapper">
  <form id="form-barang" class="card-form" action="{{ route('barang.store') }}" method="POST">
    @csrf

    <div class="input-group">
      <label>Nama Barang</label>
      <input type="text" name="nama_barang" required>
    </div>

    <div class="input-group">
      <label>Merk Barang</label>
      <input type="text" name="merk_barang" required>
    </div>

    <div class="input-group">
      <label>Tanggal Pembelian</label>
      <input type="date" name="tanggal_pembelian" required>
    </div>

    <div class="input-group">
      <label>Asal Usul</label>
      <input type="text" name="asal_usul" required>
    </div>

    <div class="input-group">
      <label>Harga Barang</label>
      <input type="number" name="harga_barang" required>
    </div>

    <div class="input-group">
      <label>Stok</label>
      <input type="number" name="stok" required>
    </div>

    <button type="button" id="btn-simpan" class="btn-simpan">Simpan</button>
  </form>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Konfirmasi sebelum simpan
  document.getElementById('btn-simpan').addEventListener('click', function(e) {
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda akan menyimpan data barang baru!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Simpan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-barang').submit();
      }
    });
  });
</script>

<!-- Notifikasi sukses -->
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

@endsection
