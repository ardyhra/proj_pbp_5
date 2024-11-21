<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'tahunajaran';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_tahun',
        'tahun_ajaran'
    ];

    // Relasi dengan model Jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_tahun', 'id_tahun');
    }
}

