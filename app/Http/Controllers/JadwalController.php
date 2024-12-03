<?php

// class JadwalController extends Controller
// {
//     // public function index(Request $request)
//     // {
//     //     // Daftar semester ganjil dan genap
//     //     $semesterList = [
//     //         'ganjil' => '2023/2024 Ganjil',
//     //         'genap' => '2023/2024 Genap',
//     //     ];

//     //     // Ambil parameter semester dari URL, default ke 'ganjil'
//     //     $selectedSemester = $request->query('semester', 'ganjil'); // Default ke 'ganjil'

//     //     // Validasi semester
//     //     if (!array_key_exists($selectedSemester, $semesterList)) {
//     //         abort(404, 'Semester tidak valid');
//     //     }

//     //     // Data jadwal untuk ganjil atau genap
//     //     $semesterData = $selectedSemester === 'ganjil'
//     //         ? [
//     //             ['id' => 1, 'name' => 'Semester 1'],
//     //             ['id' => 3, 'name' => 'Semester 3'],
//     //             ['id' => 5, 'name' => 'Semester 5'],
//     //             ['id' => 7, 'name' => 'Semester 7'],
//     //         ]
//     //         : [
//     //             ['id' => 2, 'name' => 'Semester 2'],
//     //             ['id' => 4, 'name' => 'Semester 4'],
//     //             ['id' => 6, 'name' => 'Semester 6'],
//     //             ['id' => 8, 'name' => 'Semester 8'],
//     //         ];

//     //     // Kirim data ke view
//     //     return view('kaprodi.manajemen-jadwal-kaprodi', compact('semesterList', 'selectedSemester', 'semesterData'));
//     // }
//     public function index()
//     {
//         $jadwals = Jadwal::with(['prodi', 'ruang', 'tahun'])->get();
//         return view('jadwal.index', compact('jadwals'));
//     }

//     public function view(Request $request)
//     {
//         $semester = $request->query('semester');
//         $section = $request->query('section');

//         $jadwal = Jadwal::where('semester', $semester)
//                         ->where('section', $section)
//                         ->get();

//         return view('jadwal.view-jadwal', compact('jadwal', 'semester', 'section'));
//     }

//     public function editJadwal($id)
//     {
//         $jadwal = Jadwal::find($id);

//         if (!$jadwal) {
//             return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
//         }

//         return view('edit-jadwal', compact('jadwal'));
//     }

//     // public function edit($semester, $section)
//     // {
//     //     // Ambil data jadwal berdasarkan semester dan section
//     //     $jadwal = Jadwal::where('semester', $semester)
//     //                     ->where('section', $section)
//     //                     ->get();

//     //     // Return ke view edit-jadwal.blade.php dengan data jadwal
//     //     return view('edit-jadwal', compact('jadwal', 'semester', 'section'));
//     // }

//     public function update(Request $request)
//     {
//         $jadwal = Jadwal::find($request->id);
//         $jadwal->update($request->all());

//         return redirect()->route('manajemen-jadwal-kaprodi', ['semester' => $request->semester]);
//     }

//     public function apply(Request $request)
//     {
//         // Logic untuk menandai jadwal sebagai "final"
//         return back()->with('success', 'Jadwal berhasil di-apply.');
//     }
// }

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('jadwals.index', compact('jadwals'));
    }
    public function create()
    {
        return view('jadwals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kode_mk' => 'required',
            'id_ruang' => 'required',
            'id_tahun' => 'required',
            'id_prodi' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwals.index')
                         ->with('success', 'Jadwal created successfully.');
    }

    public function show(Jadwal $jadwal)
    {
        return view('jadwals.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        return view('jadwals.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kode_mk' => 'required',
            'id_ruang' => 'required',
            'id_tahun' => 'required',
            'id_prodi' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwals.index')
                         ->with('success', 'Jadwal updated successfully.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwals.index')
                         ->with('success', 'Jadwal deleted successfully.');
    }

    public function dashboard() { 
        $currentYear = TahunAjaran::orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->first(); 
        if (!$currentYear) { 
            return redirect()->route('dashboard.kaprodi')->with('error', 'Tahun Ajaran belum tersedia.'); 
        } 
        $jumlahRuang = Jadwal::distinct('id_ruang')->count('id_ruang'); 
        $jumlahDosen = 30; // Misal data dari tabel dosen 
        $jumlahMahasiswa = 200; // Misal data dari tabel mahasiswa 
        $jumlahMataKuliah = Jadwal::where('id_tahun', $currentYear->id)->distinct('kode_mk')->count('kode_mk'); 
        $statusPenyusunan = [ 
            'scheduled' => Jadwal::where('id_tahun', $currentYear->id)->count(), 
            'not_scheduled' => 100 - Jadwal::where('id_tahun', $currentYear->id)->count() // Misal total 100 MK 
        ]; 
        return view('kaprodi.dashboard', compact('jumlahRuang', 'jumlahDosen', 'jumlahMahasiswa', 'jumlahMataKuliah', 'statusPenyusunan', 'currentYear'));
    }
}

