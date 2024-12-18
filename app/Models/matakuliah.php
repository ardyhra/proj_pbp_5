<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $primaryKey = 'kode_mk';  // Assuming 'kode_mk' is the primary key
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'plot_semester','jenis'];

    public function jadwal()
    {
        return $this->hasMany(jadwal::class, 'kode_mk', 'kode_mk');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
}
