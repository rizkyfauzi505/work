@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Tambah Barang
</div>

<div class="form-wrapper">
  <form class="card-form" action="{{ route('barang.store') }}" method="POST">
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

    <button type="submit" class="btn-simpan">Simpan</button>
  </form>
</div>
@endsection
