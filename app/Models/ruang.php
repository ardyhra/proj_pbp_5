<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang'; // Nama tabel
    protected $primaryKey = 'id_ruang'; // Primary key tabel
    public $incrementing = false; // Karena id_ruang bukan auto-increment
    protected $keyType = 'string'; // Tipe primary key
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = ['id_ruang', 'blok_gedung', 'lantai', 'kapasitas'];
}
