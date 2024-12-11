<?php

namespace App\Models;

use App\Models\mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class irs extends Model
{
    use HasFactory;

    protected $table = 'irs';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nim',
        'id_jadwal',
        'status',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'nim', 'nim');
    }
    
    public function jadwal()
    {
        return $this->belongsTo(jadwal::class,'id_jadwal', 'id_jadwal');
    }

}
