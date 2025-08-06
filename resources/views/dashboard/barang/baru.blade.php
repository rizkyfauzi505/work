@extends('layouts.dashboard')

@section('content')
<div class="topbar">
  <button id="menuToggle" class="menu-toggle"><i class="fas fa-bars"></i></button>
  Barang Baru (30 Hari Terakhir)
</div>

<div class="data-table">
  @if($barang->isEmpty())
    <p>Tidak ada barang baru dalam 30 hari terakhir.</p>
  @else
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Merk</th>
          <th>Tanggal Pembelian</th>
          <th>Asal Usul</th>
          <th>Harga</th>
          <th>Stok</th>
        </tr>
      </thead>
      <tbody>
        @foreach($barang as $item)
        <tr>
          <td>{{ $item->nama_barang }}</td>
          <td>{{ $item->merk_barang }}</td>
          <td>{{ $item->tanggal_pembelian }}</td>
          <td>{{ $item->asal_usul }}</td>
          <td>Rp{{ number_format($item->harga_barang, 0, ',', '.') }}</td>
          <td>{{ $item->stok }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection
