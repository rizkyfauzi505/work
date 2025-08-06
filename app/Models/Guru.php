<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'nip',
        'nama_guru',
        'password',
        'password_plain'
    ];

    public $timestamps = false;

    protected $hidden = [
        'password_plain'
    ];
}
