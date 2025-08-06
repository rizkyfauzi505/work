<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Data Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
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
</body>
</html>
