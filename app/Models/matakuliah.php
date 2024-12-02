<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';

    public function jadwal()
    {
        return $this->hasMany(jadwal::class, 'kode_mk', 'kode_mk');
    }
}
