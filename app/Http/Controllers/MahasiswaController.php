<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa; 
use App\Models\Jadwal; 
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa dan jadwal dari database
        $mahasiswa = Mahasiswa::find(auth()->id());
        $jadwal = JadwalKuliah::where('mahasiswa_id', $mahasiswa->id)->get();
        $informasiJadwal = InformasiPerubahanJadwal::all(); // Contoh model lain

        // Kirim data ke view
        return view('dashboard', compact('mahasiswa', 'jadwal', 'informasiJadwal'));
    }
}
