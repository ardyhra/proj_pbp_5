<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    public $timestamps = false;

    protected $fillable = ['id_prodi', 'nama_prodi', 'strata', 'id_fakultas'];


    // Relasi ke UsulanRuangKuliah
    public function usulanRuangKuliah()
    {
        return $this->hasMany(UsulanRuangKuliah::class, 'id_prodi', 'id_prodi');
    }

    public function jadwal()
    {
        return $this->hasMany(jadwal::class, 'id_prodi', 'id_prodi');
    }

}
