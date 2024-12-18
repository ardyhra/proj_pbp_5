<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\tahunajaran;
use App\Models\ProgramStudi;
use App\Models\Usulanjadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

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

    public function dashboardKaprodi()
    {
        $jumlahRuang = Ruang::count();

        $jumlahDosen = Dosen::count();

        $jumlahMataKuliah = MataKuliah::count();
       
        $jumlahMahasiswa = Mahasiswa::count();

        return view('kaprodi.dashboard-kaprodi', compact(
            'jumlahRuang',
            'jumlahDosen',
            'jumlahMataKuliah',
            'jumlahMahasiswa'
        ));
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

    public function manajemenMatkul(Request $request)
    {
        // Ambil semua data mata kuliah
        $mataKuliah = matakuliah::all();
        $matkuls = DB::table('matakuliah')
                    ->orderBy('kode_mk')
                    ->get();
        // Kirim data ke view 'kaprodi.manajemen-matkul'
        return view('kaprodi.manajemen-matkul-kaprodi', compact('mataKuliah', 'matkuls'));
    }

    public function rekapJadwal()
    {
        // Ambil data tahun ajaran dan program studi dari database
        $tahunajarans = TahunAjaran::all(); // Model TahunAjaran
        $prodis = Programstudi::all(); // Model Prodi

        // Kirim data ke view
        return view('kaprodi.rekapjadwal', compact('tahunajarans', 'prodis'));
    }    
}

