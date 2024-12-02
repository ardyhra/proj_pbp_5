<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tahun_ajaran';

    // Primary key
    protected $primaryKey = 'id_tahun';

    // Relasi ke model Jadwal
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_tahun', 'id_tahun');
    }
}
