<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status';
    public $incrementing = false;
    protected $keyType = 'string';

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    // Relasi ke Tahun Ajaran
    public function tahun_ajaran()
    {
        return $this->belongsTo(tahunajaran::class, 'id_tahun', 'id_tahun');
    }
}
