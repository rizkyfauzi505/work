<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'merk_barang',
        'tanggal_pembelian',
        'asal_usul',
        'harga_barang',
        'stok'
    ];

    public $timestamps = false;
}
