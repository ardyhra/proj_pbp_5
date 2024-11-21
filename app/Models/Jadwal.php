<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'jadwal';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_jadwal', 
        'kelas', 
        'hari', 
        'waktu_mulai', 
        'waktu_selesai', 
        'nidn', 
        'kode_mk', 
        'id_ruang', 
        'id_tahun'
    ];

    // Relasi dengan model TahunAjaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun', 'id_tahun');
    }
}


// protected $table = 'jadwal';
    // protected $primaryKey = 'id_jadwal';

    // protected $fillable = [
    //     'kelas',
    //     'hari',
    //     'waktu_mulai',
    //     'waktu_selesai',
    //     'nidn',
    //     'kode_mk',
    //     'id_ruang',
    //     'id_tahun',
    // ];
