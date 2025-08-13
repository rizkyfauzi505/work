<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    // Field yang boleh diisi mass assignment
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'keterangan',
        'status',
        'user_id',  // kalau kamu punya relasi ke user/guru pembuat
    ];

    // Jika kamu punya tabel users/gurus, bisa bikin relasi seperti ini:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
        // atau ke model Guru::class, tergantung struktur database kamu
    }
}
