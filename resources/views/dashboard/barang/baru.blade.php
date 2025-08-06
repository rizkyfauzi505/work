@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Barang Baru
</div>

<div class="main-content">
  <h2>Daftar Barang Baru (30 Hari Terakhir)</h2>

  <table border="1" cellpadding="8">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Merk</th>
        <th>Tanggal Pembelian</th>
        <th>Asal Usul</th>
        <th>Harga</th>
        <th>Stok</th>
      </tr>
    </thead>
    <tbody>
      @forelse($barang as $index => $b)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $b->nama_barang }}</td>
        <td>{{ $b->merk_barang }}</td>
        <td>{{ $b->tanggal_pembelian }}</td>
        <td>{{ $b->asal_usul }}</td>
        <td>Rp{{ number_format($b->harga_barang, 0, ',', '.') }}</td>
        <td>{{ $b->stok }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;">Tidak ada barang baru.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
