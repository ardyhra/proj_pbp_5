<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usulanjadwal extends Model
{
    use HasFactory;

    protected $table = 'usulanjadwal';

    protected $fillable = [
        'id_tahun',
        'id_prodi',
        'status',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun');
    }

    public function prodi()
    {
        return $this->belongsTo(Programstudi::class, 'id_prodi');
    }
}
