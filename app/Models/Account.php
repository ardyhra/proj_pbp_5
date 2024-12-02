<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $fillable = [
        'email', 
        'password', 
        'mahasiswa', 
        'pembimbing_akademik', 
        'ketua_program_studi', 
        'dekan', 
        'bagian_akademik',
        'related_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(mahasiswa::class, 'related_id', 'nim');
    }

    public function dosen()
    {
        return $this->belongsTo(dosen::class, 'related_id', 'nidn');
    }
}





// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Account extends Model
// {
//     use HasFactory;
// }
