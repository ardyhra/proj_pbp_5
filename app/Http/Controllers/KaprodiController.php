<?php
// namespace App\Http\Controllers;
// use App\Models\Ruang;
// use App\Models\Dosen;
// use App\Models\MataKuliah;
// use App\Models\TahunAjaran;
// use App\Models\Jadwal;
// use App\Models\Monitoring;
// use Illuminate\Http\Request;


// class KaprodiController extends Controller
// {
//     public function manajemenJadwal(Request $request)
//     {
//         // Ambil data tahun ajaran dan semester
//         $tahunAjarans = TahunAjaran::all();
//         $id_tahun = $request->query('id_tahun');
//         $semester = $request->query('semester');
    
//         // Tentukan semester berdasarkan digit terakhir id_tahun (ganjil/genap)
//         $lastDigit = substr($id_tahun, -1);
//         $semesterType = ($lastDigit == '1') ? 'ganjil' : 'genap';
    
//         // Tentukan daftar semester berdasarkan jenisnya (ganjil/genap)
//         $semesterNumbers = ($semesterType === 'ganjil') ? [1, 3, 5, 7] : [2, 4, 6, 8];
    
//         // Ambil data jadwal dengan relasi ke matakuliah dan filter berdasarkan semester
//         $jadwals = Jadwal::with('matakuliah')
//                          ->where('id_tahun', $id_tahun)
//                          ->whereHas('matakuliah', function($query) use ($semesterNumbers) {
//                              $query->whereIn('plot_semester', $semesterNumbers); // Filter berdasarkan semester ganjil/genap
//                          })
//                          ->get();
    
//         // Debugging: Periksa data yang dikirimkan
//         //dd($jadwals);  // Cek apakah $jadwals berisi data yang sesuai
    
//         return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals', 'semesterType', 'id_tahun', 'semester'));
        
//     }
    
//     public function viewJadwal($id)
//     {
//         // Ambil data jadwal berdasarkan id_jadwal
//         $jadwal = Jadwal::with('tahunAjaran') // Mengambil relasi tahun ajaran
//                         ->findOrFail($id); // Pastikan id ditemukan
    
//         return view('kaprodi.view-jadwal', compact('jadwal'));
//     }
//     // public function viewJadwal($id)
//     // {
//     //     // Ambil data jadwal berdasarkan id_jadwal
//     //     $jadwal = Jadwal::with('tahunAjaran')->find($id);

//     //     if (!$jadwal) {
//     //         return redirect()->route('manajemen-jadwal-kaprodi.index')
//     //                         ->with('error', 'Jadwal tidak ditemukan!');
//     //     }

//     //     // Cek apakah tahunAjaran tersedia
//     //     if (!$jadwal->tahunAjaran) {
//     //         return redirect()->route('manajemen-jadwal-kaprodi.index')
//     //                         ->with('error', 'Tahun ajaran tidak ditemukan untuk jadwal ini!');
//     //     }

//     //     return view('kaprodi.view-jadwal', compact('jadwal'));
//     // }


//     // Fungsi untuk mengedit jadwal
//     public function editJadwal(Request $request)
//     {
//         // Ambil semester dan section dari query string
//         $semester = $request->query('semester', 'ganjil');

//         // Ambil data mata kuliah berdasarkan plot_semester
//         $mataKuliah = MataKuliah::where('plot_semester', $semester)->get();

//         // Ambil jadwal berdasarkan kode_mk dari mata kuliah yang sesuai
//         $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
//                          ->get();

//         return view('kaprodi.edit-jadwal', compact('jadwals', 'semester'));
//     }

//     // Apply jadwal (mengajukan untuk disetujui)
//     public function applyJadwal(Request $request)
//     {
//         // Ambil semester dari query string
//         $semester = $request->query('semester', 'ganjil');

//         // Ambil data mata kuliah berdasarkan plot_semester
//         $mataKuliah = MataKuliah::where('plot_semester', $semester)->get();

//         // Ambil jadwal berdasarkan kode_mk dari mata kuliah yang sesuai
//         $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
//                          ->get();

//         // Proses pengajuan jadwal untuk disetujui (misalnya, mengubah status jadi 'pending')
//         foreach ($jadwals as $item) {
//             $item->status = 'pending';  // Mengubah status menjadi 'pending'
//             $item->save();
//         }

//         // Redirect ke halaman manajemen jadwal dengan pesan sukses
//         return redirect()->route('manajemen-jadwal-kaprodi.index', ['semester' => $semester])
//                          ->with('success', 'Jadwal berhasil diajukan untuk disetujui!');
//     }

    
    
//     // }
//     public function dashboard()
//     {
//         return view('kaprodi/dashboard-kaprodi');
//     }

//     // Menampilkan halaman manajemen jadwal
//     // Menampilkan halaman manajemen jadwal
//     public function index(Request $request)
//     {
//         $tahunAjarans = TahunAjaran::all();
//         $jadwals = Jadwal::all(); // Ambil semua jadwal

//         return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals'));
//     }

//         // Ambil jadwal berdasarkan tahun ajaran via AJAX
//     public function getJadwalByTahun(Request $request)
//     {
//         if($request->ajax()){
//             $id_tahun = $request->id_tahun;
//             $jadwals = Jadwal::where('id_tahun', $id_tahun)->get();

//             return response()->json([
//                 'jadwals' => $jadwals
//             ]);
//         }
//     }

    
//     // Menampilkan form tambah jadwal
//     public function create()
//     {
//         $dosens = Dosen::all();
//         $ruangs = Ruang::all();
//         $matakuliahs = Matakuliah::all();
//         $tahunAjarans = TahunAjaran::all();

//         return view('kaprodi.create-jadwal', compact('dosens', 'ruangs', 'matakuliahs', 'tahunAjarans'));
//     }

//     // Menyimpan jadwal baru ke database
//     public function store(Request $request)
// {
//     $request->validate([
//         'kelas' => 'required',
//         'hari' => 'required',
//         'waktu_mulai' => 'required',
//         'waktu_selesai' => 'required',
//         'kode_mk' => 'required',
//         'id_ruang' => 'required',
//         'id_tahun' => 'required',
//         'id_prodi' => 'required',
//         'kuota' => 'required|integer',  // Validasi kuota
//     ]);

//     Jadwal::create([
//         'kelas' => $request->kelas,
//         'hari' => $request->hari,
//         'waktu_mulai' => $request->waktu_mulai,
//         'waktu_selesai' => $request->waktu_selesai,
//         'kode_mk' => $request->kode_mk,
//         'id_ruang' => $request->id_ruang,
//         'id_tahun' => $request->id_tahun,
//         'id_prodi' => $request->id_prodi,
//         'kuota' => $request->kuota,  // Mengisi kolom kuota
//     ]);

//     return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil ditambahkan!');
// }

//     // Menghapus jadwal
//     public function destroy($id)
//     {
//         $jadwal = Jadwal::findOrFail($id);
//         $jadwal->delete();

//         return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil dihapus!');
//     }


//     public function monitoring()
//     {

//         $data = [
//             [
//                 'id' => 1,
//                 'nama_pembimbing' => 'Udin Saripudin, S.Kom, M.Cs',
//                 'jumlah_isi' => 20,
//                 'total_mahasiswa' => 40,
//                 'persentase' => 50,
//             ],
//             [
//                 'id' => 2,
//                 'nama_pembimbing' => 'Dr. Eng. Adi Wibowo, S.Si, M.Kom.',
//                 'jumlah_isi' => 40,
//                 'total_mahasiswa' => 40,
//                 'persentase' => 100,
//             ],
//         ];

//         return view('kaprodi.monitoring-kaprodi', compact('data'));
        
        
//         // // Mengambil semua data monitoring
//         // $data = Monitoring::all();

//         // // Menampilkan data ke view
//         // return view('kaprodi.monitoring-kaprodi', compact('data'));
//     }

//     public function viewMonitoring($id)
//     {
//         // Contoh data monitoring yang ditampilkan
//         return "Viewing monitoring data for ID: $id";
//     }

// }

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\Jadwal;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class KaprodiController extends Controller
{   
    
    // public function kaprodi(Request $request)
    // {
    //     // Ambil data Tahun Ajaran dan Program Studi
    //     $tahunajarans = TahunAjaran::all(); // Ambil semua data Tahun Ajaran
    //     $prodis = Programstudi::all(); // Ambil semua data Prodi

    //     // Filter jadwal berdasarkan id_tahun dan id_prodi
    //     $jadwals = Jadwal::with(['matakuliah', 'ruang'])
    //                      ->when($request->id_tahun, function ($query) use ($request) {
    //                          return $query->where('id_tahun', $request->id_tahun);
    //                      })
    //                      ->when($request->id_prodi, function ($query) use ($request) {
    //                          return $query->where('id_prodi', $request->id_prodi);
    //                      })
    //                      ->get();
    //                      dd($request->query()); // Cek apakah id_tahun dan id_prodi ada
    //     // Kirim data ke view
    //     return view('manajemen-jadwal-kaprodi', compact('jadwals', 'tahunajarans', 'prodis'));
    // }

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
    
    public function dashboard()
    {
        return view('kaprodi.dashboard-kaprodi'); // Ganti dengan path yang benar sesuai dengan view yang kamu miliki
    }
    // public function manajemenJadwal(Request $request)
    // {
    //     // Ambil data tahun ajaran dan program studi
    //     $tahunAjarans = TahunAjaran::all(); // Ambil semua data tahun ajaran
    //     $prodis = ProgramStudi::all(); // Ambil semua data program studi
    //     $id_tahun = $request->query('id_tahun');
    //     $id_prodi = $request->query('id_prodi');
        
    //     // Ambil data jadwal berdasarkan id_tahun dan id_prodi
    //     $jadwals = Jadwal::with('matakuliah')
    //                      ->where('id_tahun', $id_tahun)
    //                      ->where('id_prodi', $id_prodi)
    //                      ->get();
    
    //     return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'prodis', 'jadwals', 'id_tahun', 'id_prodi'));
    // }
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

    // AJAX untuk mengambil jadwal berdasarkan tahun ajaran dan prodi
    public function getJadwalByTahunProdi(Request $request)
    {
        if($request->ajax()){
            $id_tahun = $request->id_tahun;
            $id_prodi = $request->id_prodi;

            // Ambil jadwal berdasarkan id_tahun dan id_prodi
            $jadwals = Jadwal::where('id_tahun', $id_tahun)
                             ->where('id_prodi', $id_prodi)
                             ->get();

            return response()->json([
                'jadwals' => $jadwals
            ]);
        }
    }


    // Fungsi untuk melihat jadwal
    public function viewJadwal($id)
    {
        // Ambil data jadwal berdasarkan id_jadwal
        $jadwal = Jadwal::with('tahunAjaran', 'matakuliah', 'ruang', 'dosen') // Mengambil relasi terkait
                        ->findOrFail($id); // Pastikan id ditemukan
    
        return view('kaprodi.view-jadwal', compact('jadwal'));
    }

    // Menyimpan jadwal baru
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'id_dosen' => 'required|exists:dosen,id',
            'id_ruang' => 'required|exists:ruang,id',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kode_mk' => 'required',
            'kuota' => 'required|integer',
        ]);

        Jadwal::create([
            'id_prodi' => $request->id_prodi,
            'id_dosen' => $request->id_dosen,
            'id_ruang' => $request->id_ruang,
            'kelas' => $request->kelas,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'kode_mk' => $request->kode_mk,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil disimpan!');
    }

    // Fungsi untuk mengedit jadwal
    public function editJadwal(Request $request, $id)
    {
        // Ambil data jadwal berdasarkan id
        $jadwal = Jadwal::findOrFail($id);
        
        // Ambil data mata kuliah dan dosen
        $mataKuliah = MataKuliah::all(); 
        $dosens = Dosen::all();
        $ruangs = Ruang::all();
        $prodis = ProgramStudi::all();

        return view('kaprodi.edit-jadwal', compact('jadwal', 'mataKuliah', 'dosens', 'ruangs', 'prodis'));
    }

    // Fungsi untuk menyimpan jadwal yang diedit
    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'id_dosen' => 'required|exists:dosen,id',
            'id_ruang' => 'required|exists:ruang,id',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kode_mk' => 'required',
            'kuota' => 'required|integer',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'id_prodi' => $request->id_prodi,
            'id_dosen' => $request->id_dosen,
            'id_ruang' => $request->id_ruang,
            'kelas' => $request->kelas,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'kode_mk' => $request->kode_mk,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    // Fungsi untuk apply jadwal
    public function applyJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->status = 'pending'; // Ubah status menjadi 'pending'
        $jadwal->save();

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diajukan untuk disetujui!');
    }

    // Fungsi untuk menghapus jadwal
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil dihapus!');
    }

}

