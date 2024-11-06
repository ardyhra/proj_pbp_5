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
        'bagian_akademik'
    ];

    protected $hidden = [
        'password',
    ];

   

}

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Account extends Model
// {
//     use HasFactory;
// }
