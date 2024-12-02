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
        return $this->belongsTo(tahunajaran::class, 'id_tahun', 'id_tahun');
    }

    public function ruang()
    {
        return $this->belongsTo(ruang::class, 'id_ruang', 'id_ruang');
    }
    
    public function matkul()
    {
        return $this->belongsTo(matakuliah::class, 'kode_mk', 'kode_mk');
    }
    
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
    
    public function irs()
    {
        return $this->hasMany(irs::class, 'id_jadwal', 'id_jadwal');
    }

}
