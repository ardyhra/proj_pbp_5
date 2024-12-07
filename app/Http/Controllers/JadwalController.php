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
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class JadwalController extends Controller
{
    public function manajemenJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan program studi
        $tahunAjarans = TahunAjaran::all();
        $prodis = ProgramStudi::all();  // Mengambil semua program studi
        $id_tahun = $request->query('id_tahun');
        $id_prodi = $request->query('id_prodi');

        // Ambil data jadwal berdasarkan id_tahun dan id_prodi
        $jadwals = Jadwal::where('id_tahun', $id_tahun)
                         ->where('id_prodi', $id_prodi)
                         ->get();

        // Mengirim data ke view
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'prodis', 'jadwals', 'id_tahun', 'id_prodi'));
    }
    public function kaprodi(Request $request)
{
    // Ambil data Tahun Ajaran dan Program Studi untuk dropdown
    $tahunajarans = TahunAjaran::all();
    $prodis = ProgramStudi::all();

    // Ambil jadwal berdasarkan filter id_tahun dan id_prodi
    $jadwals = Jadwal::with(['prodi', 'tahunAjaran', 'matakuliah', 'ruang'])
                     ->where('id_tahun', $request->input('id_tahun'))
                     ->where('id_prodi', $request->input('id_prodi'))
                     ->get();

    // Return view dengan data jadwal dan pilihan tahun ajaran dan prodi
    return view('manajemen-jadwal-kaprodi', compact('jadwals', 'tahun_ajaran', 'prodi'));
}   
public function index(Request $request)
{
    $id_tahun = $request->query('id_tahun');
    $id_prodi = $request->query('id_prodi');
    
    // Ambil data program studi berdasarkan id_prodi
    $prodi = Programstudi::find($id_prodi); // Prodi adalah model yang sesuai dengan tabel prodi di database
    $tahun_ajaran = tahunajaran::find($id_tahun);
    
    // Query untuk mengambil jadwal dengan join ke tabel matakuliah dan ruang
    $jadwals = DB::table('jadwal')
                ->join('matakuliah', 'jadwal.kode_mk', '=', 'matakuliah.kode_mk') // Join dengan tabel matakuliah berdasarkan kode_mk
                ->join('ruang', 'jadwal.id_ruang', '=', 'ruang.id_ruang') // Join dengan tabel ruang berdasarkan id_ruang
                ->where('jadwal.id_tahun', $id_tahun)
                ->where('jadwal.id_prodi', $id_prodi)
                ->select('jadwal.*', 'matakuliah.nama_mk', 'ruang.id_ruang') // Pilih kolom yang ingin ditampilkan
                ->get();
    // Pastikan data jadwals sudah benar
    //dd($jadwals); // Untuk melihat data jadwal yang diambil

    return view('jadwal.view', compact('jadwals',  'prodi', 'tahun_ajaran'));
}
    // Form untuk menambah jadwal
    // public function create()
    // {
    //     // Ambil data tahun, prodi, dan mata kuliah untuk dropdown
    //     $tahun_ajaran = TahunAjaran::all();
    //     $prodi = ProgramStudi::all();
    //     $matakuliah = Matakuliah::all();
    //     $ruang = Ruang::all();

    //     return view('jadwal.create', compact('tahun_ajaran', 'prodi', 'matakuliah', 'ruang'));
    // }
    // Menampilkan form untuk menambah jadwal
    public function create(Request $request)
{
    $idTahun = $request->query('id_tahun');  // Ambil nilai id_tahun dari URL
    $idProdi = $request->query('id_prodi');  // Ambil nilai id_prodi dari URL

    $matakuliah = Matakuliah::all();  // Ambil data matakuliah
    $ruang = Ruang::all();
    // Kirim data ke view
    return view('jadwal.create', compact('matakuliah', 'ruang','idTahun', 'idProdi'));
}
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kode_mk' => 'required|exists:matakuliah,kode_mk',
        'kelas' => 'required|string|max:10',
        'hari' => 'required|integer',
        'waktu_mulai' => 'required|date_format:H:i',
        'waktu_selesai' => 'required|date_format:H:i',
        'id_ruang' => 'required|exists:ruang,id_ruang',
        'kuota' => 'required|integer|min:1',
        'id_tahun' => 'required|integer',
        'id_prodi' => 'required|integer',
    ]);

    $idTahun = $request->id_tahun;
    $idProdi = $request->id_prodi;

    // Generate ID Jadwal
    $lastJadwal = Jadwal::where('id_tahun', $idTahun)
                        ->where('id_prodi', $idProdi)
                        ->orderBy('id_jadwal', 'desc')
                        ->first();

    $lastIdJadwal = $lastJadwal ? (int)substr($lastJadwal->id_jadwal, -3) : 100;
    $newIdJadwal = $idTahun . $idProdi . str_pad($lastIdJadwal + 1, 3, '0', STR_PAD_LEFT);

    // Simpan jadwal baru ke database
    Jadwal::create([
        'id_jadwal' => $newIdJadwal,
        'kode_mk' => $request->kode_mk,
        'kelas' => $request->kelas,
        'hari' => $request->hari,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'id_ruang' => $request->id_ruang,
        'kuota' => $request->kuota,
        'id_tahun' => $idTahun,
        'id_prodi' => $idProdi,
    ]);

    // Redirect ke halaman index setelah berhasil
    return redirect()->route('jadwal.index')->with('success', 'Jadwal kuliah berhasil ditambahkan!');
}


    // Menyimpan data jadwal ke dalam database
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'kode_mk' => 'required|exists:matakuliah,kode_mk',
    //         'kelas' => 'required|string|max:10',
    //         'hari' => 'required|integer',
    //         'waktu_mulai' => 'required|date_format:H:i',
    //         'waktu_selesai' => 'required|date_format:H:i',
    //         'id_ruang' => 'required|exists:ruang,id_ruang',
    //         'kuota' => 'required|integer|min:1',
    //         // Pastikan ID Prodi dan ID Tahun diterima dengan benar
    //         'id_tahun' => 'required|integer',
    //         'id_prodi' => 'required|integer',
    //     ]);

    //     // Generate ID Jadwal berdasarkan Tahun, Prodi, dan counter
    //     $idTahun = $request->id_tahun;
    //     $idProdi = $request->id_prodi;

    //     // Mencari ID Jadwal terakhir berdasarkan Tahun dan Prodi
    //     $lastJadwal = Jadwal::where('id_tahun', $idTahun)
    //                         ->where('id_prodi', $idProdi)
    //                         ->orderBy('id_jadwal', 'desc')
    //                         ->first();

    //     // Jika jadwal ada, ambil 3 digit terakhir dan tambah 1, jika belum ada, mulai dari 101
    //     $lastIdJadwal = $lastJadwal ? (int)substr($lastJadwal->id_jadwal, -3) : 100;
    //     $newIdJadwal = $idTahun . $idProdi . str_pad($lastIdJadwal + 1, 3, '0', STR_PAD_LEFT);

    //     // Menyimpan data jadwal ke database
    //     Jadwal::create([
    //         'id_jadwal' => $newIdJadwal,
    //         'kode_mk' => $request->kode_mk,
    //         'kelas' => $request->kelas,
    //         'hari' => $request->hari,
    //         'waktu_mulai' => $request->waktu_mulai,
    //         'waktu_selesai' => $request->waktu_selesai,
    //         'id_ruang' => $request->id_ruang,
    //         'kuota' => $request->kuota,
    //         'id_tahun' => $idTahun,
    //         'id_prodi' => $idProdi,
    //     ]);

    //     // Redirect kembali dengan pesan sukses
    //     return redirect()->route('jadwal.index')->with('success', 'Jadwal kuliah berhasil ditambahkan!');
    // }   
//     public function create()
// {
//     return view('jadwal.create'); // Tampilkan form tambah jadwal
// }
//     public function store(Request $request)
//     {
//         $request->validate([
//             'kelas' => 'required',
//             'hari' => 'required',
//             'waktu_mulai' => 'required',
//             'waktu_selesai' => 'required',
//             'kode_mk' => 'required',
//             'nama_mk' => 'required',
//             'id_ruang' => 'required',
//             'id_tahun' => 'required',
//             'id_prodi' => 'required',
//             'kuota' => 'nullable|integer',
//         ]);

//          // Generate ID Jadwal (bisa dengan cara tertentu, misalnya ID unik atau UUID)
//          $id_jadwal = 'JAD' . strtoupper(uniqid());

//          Jadwal::create([
//              'id_jadwal' => $id_jadwal,
//              'kelas' => $request->kelas,
//              'hari' => $request->hari,
//              'waktu_mulai' => $request->waktu_mulai,
//              'waktu_selesai' => $request->waktu_selesai,
//              'kode_mk' => $request->kode_mk,
//              'id_ruang' => $request->id_ruang,
//              'id_tahun' => $request->id_tahun,
//              'id_prodi' => $request->id_prodi,
//              'kuota' => $request->kuota ?? 50,  // Default kuota 50
//          ]);
 
//          return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
//     }

    public function show(Request $request)
{
    $tahunAjaran = $request->input('id_tahun');
    $prodi = $request->input('id_prodi');

    $jadwals = Jadwal::where('id_tahun', $tahunAjaran)
                    ->where('id_prodi', $prodi)
                    ->get();

    return view('jadwal.view', compact('jadwals'));
}


public function edit($id)
{
    // Ambil data jadwal berdasarkan ID
    $jadwal = Jadwal::find($id);
    
    // Ambil data terkait untuk select options (misal mata kuliah, ruang, dll)
    $matakuliah = Matakuliah::all(); // Atau sesuaikan dengan data yang dibutuhkan
    $ruang = Ruang::all();
    $prodi = Programstudi::all(); // Sesuaikan dengan program studi yang ada
    $tahun_ajaran = TahunAjaran::all();
    
    return view('jadwal.edit', compact('jadwal', 'matakuliah', 'ruang', 'prodi', 'tahun_ajaran'));
}

     // Mengupdate jadwal yang sudah ada
     public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'kode_mk' => 'required',
        'kelas' => 'required',
        'hari' => 'required',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'id_ruang' => 'required',
        'kuota' => 'required|integer',
    ]);

    // Cari jadwal yang ingin diedit
    $jadwal = Jadwal::findOrFail($id);

    // Update data jadwal
    $jadwal->update([
        'kode_mk' => $request->kode_mk,
        'kelas' => $request->kelas,
        'hari' => $request->hari,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'id_ruang' => $request->id_ruang,
        'kuota' => $request->kuota,
    ]);

    return redirect()->route('jadwal.view', ['id_tahun' => $jadwal->id_tahun, 'id_prodi' => $jadwal->id_prodi])
                     ->with('success', 'Jadwal berhasil diperbarui!');
}

 

    // Menghapus jadwal
    public function destroy($id, Request $request)
    {
        // Cari jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);
    
        // Hapus data jadwal
        $jadwal->delete();
    
        // Ambil parameter id_tahun dan id_prodi dari query string
        $id_tahun = $request->input('id_tahun');
        $id_prodi = $request->input('id_prodi');
    
        // Pastikan parameter id_tahun dan id_prodi ada sebelum redirect
        return redirect()->route('jadwal.view', [
            'id_tahun' => $id_tahun,
            'id_prodi' => $id_prodi
        ])->with('success', 'Jadwal berhasil dihapus!');
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

