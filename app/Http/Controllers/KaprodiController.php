<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\Jadwal;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaprodiController extends Controller
{   
    //UNTUK LIAT KE VIEW FILTER
    public function kaprodi(Request $request)
    {
        // Ambil data Tahun Ajaran dan Program Studi
        $tahunajarans = TahunAjaran::all();
        $prodis = Programstudi::all();

        // Ambil id_tahun dan id_prodi dari URL
        $id_tahun = $request->query('id_tahun');
        $id_prodi = $request->query('id_prodi');

        // Kirim data ke view
        return view('manajemen-jadwal-kaprodi', compact('tahunajarans', 'prodis', 'id_tahun', 'id_prodi'));
    }
    //FIX 
    public function dashboard() {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();
    
        // Ambil data dosen atau kaprodi berdasarkan role atau related_id
        $dosen = $user->role == 'kaprodi' ? $user->kaprodi : $user->dosen;
    
        return view('kaprodi.dashboard-kaprodi', compact('dosen'));
    }

    public function manajemenJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan program studi
        $tahunajarans = TahunAjaran::all();
        $prodis = ProgramStudi::all();  // Mengambil semua program studi
        $id_tahun = $request->query('id_tahun');
        $id_prodi = $request->query('id_prodi');

        // Ambil data jadwal berdasarkan id_tahun dan id_prodi
        $jadwals = Jadwal::where('id_tahun', $id_tahun)
                         ->where('id_prodi', $id_prodi)
                         ->get();

        // Mengirim data ke view
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunajarans', 'prodis', 'jadwals', 'id_tahun', 'id_prodi'));
    }
}

