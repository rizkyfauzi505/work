@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Semua Stok Barang
</div>

<div class="main-content">
  <h2>Semua Stok Barang</h2>

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
      @foreach($barang as $index => $b)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $b->nama_barang }}</td>
        <td>{{ $b->merk_barang }}</td>
        <td>{{ $b->tanggal_pembelian }}</td>
        <td>{{ $b->asal_usul }}</td>
        <td>Rp{{ number_format($b->harga_barang, 0, ',', '.') }}</td>
        <td>{{ $b->stok }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
