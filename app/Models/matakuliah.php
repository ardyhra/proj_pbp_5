<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';

    protected $primaryKey = 'kode_mk';  // Assuming 'kode_mk' is the primary key

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kode_mk', 'kode_mk');
    }

    public function jadwal()
    {
        return $this->hasMany(jadwal::class, 'kode_mk', 'kode_mk');
    }
}
