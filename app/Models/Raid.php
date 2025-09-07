<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa', 'kelas', 'foto_barang', 'tanggal_waktu', 
        'penanggung_jawab', 'keterangan'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime'
    ];
}