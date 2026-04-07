<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditi extends Model
{
    // Nama tabel harus sesuai (cek apakah 'komoditis' atau 'komoditi')
    protected $table = 'komoditis';

    // WAJIB: Daftarkan semua kolom yang ingin diisi manual
    protected $fillable = [
        'tanggal',
        'nama_provinsi',
        'harga_provinsi',
        'tanaman_id'
    ];
}
