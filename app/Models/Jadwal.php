<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'kode_mk',
        'kelas',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'id_ruang',
        'id_prodi',
        'id_tahun',
    ];

    // Relasi ke model TahunAjaran
    public function tahunAjaran()
    {
        return $this->belongsTo(tahunAjaran::class, 'id_tahun', 'id_tahun');
    }
    public function matakuliah()
    {
        return $this->belongsTo(matakuliah::class, 'kode_mk', 'kode_mk');
    }
}

