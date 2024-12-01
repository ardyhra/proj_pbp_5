<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanRuangKuliah extends Model
{
    use HasFactory;

    protected $table = 'usulan_ruang_kuliah';

    protected $fillable = ['id_prodi', 'id_ruang', 'id_tahun', 'status'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun', 'id_tahun');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }



}
