<?php
namespace App\Http\Controllers;
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\Jadwal;
use App\Models\Monitoring;
use Illuminate\Http\Request;


class KaprodiController extends Controller
{
    // app/Http/Controllers/KaprodiController.php
    public function manajemenJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan semester
        $tahunAjarans = TahunAjaran::all();
        $id_tahun = $request->query('id_tahun');
        $semester = $request->query('semester');
    
        // Tentukan semester berdasarkan digit terakhir id_tahun (ganjil/genap)
        $lastDigit = substr($id_tahun, -1);
        $semesterType = ($lastDigit == '1') ? 'ganjil' : 'genap';
    
        // Ambil data jadwal dengan relasi ke matakuliah
        $jadwals = Jadwal::with('matakuliah')
                         ->where('id_tahun', $id_tahun)
                         ->whereHas('matakuliah', function($query) use ($semesterType) {
                             $query->where('plot_semester', $semesterType); // Menyaring berdasarkan semester
                         })
                         ->get();
    
        // Debugging data jadwals
        // dd($jadwals);  // Cek jika jadwals berisi data yang diharapkan
    
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals', 'semesterType', 'id_tahun', 'semester'));
    }
    

    
    
 
// public function manajemenJadwal(Request $request)
// {
//     // Ambil tahun ajaran dan semester
//     $tahunAjarans = TahunAjaran::all();  // Ambil semua tahun ajaran
//     $id_tahun = $request->query('id_tahun');
//     $semester = $request->query('semester');

//     // Tentukan semester berdasarkan id_tahun
//     $lastDigit = substr($id_tahun, -1);
//     $semesterType = ($lastDigit == '1') ? 'ganjil' : 'genap';

//     // Ambil data jadwal berdasarkan semester dan tahun ajaran
//     $jadwals = Jadwal::with('matakuliah')
//                      ->where('id_tahun', $id_tahun)
//                      ->whereHas('matakuliah', function($query) use ($semesterType) {
//                          $query->where('plot_semester', $semesterType);
//                      })
//                      ->get();

//     return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals', 'semesterType', 'id_tahun', 'semester'));
// }


// fix
        // public function manajemenJadwal(Request $request)
        // {
        //     // Ambil data tahun ajaran
        //     $tahunAjarans = TahunAjaran::all();
        //     $id_tahun = $request->query('id_tahun');
        //     $semester = $request->query('semester');
        
        //     // Tentukan semester berdasarkan digit terakhir id_tahun (ganjil/genap)
        //     $lastDigit = substr($id_tahun, -1);
        //     $semesterType = ($lastDigit == '1') ? 'ganjil' : 'genap';
        
        //     // Ambil data tahun ajaran berdasarkan id_tahun
        //     $tahunAjaran = TahunAjaran::where('id_tahun', $id_tahun)->first();
        
        //     // Ambil mata kuliah berdasarkan semester yang dipilih
        //     $mataKuliah = MataKuliah::where('plot_semester', $semesterType)->get();
        
        //     // Ambil jadwal berdasarkan kode_mk dan id_tahun
        //     $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
        //                      ->where('id_tahun', $id_tahun)
        //                      ->get();
        
        //     return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals', 'semesterType', 'id_tahun', 'semester'));
        // }
        // Menampilkan jadwal berdasarkan semester dan section
    // public function viewJadwal(Request $request)
    // {
    //     // Ambil semester dari query string (ganjil/genap)
    //     $semester = $request->query('semester', 'ganjil');

    //     // Ambil data mata kuliah berdasarkan plot_semester (ganjil/genap)
    //     $mataKuliah = MataKuliah::where('plot_semester', $semester)->get();

    //     // Ambil jadwal berdasarkan kode_mk dari mata kuliah yang sesuai
    //     $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
    //                         ->where('id_tahun', '20201') 
    //                         ->get();

    //     return view('kaprodi.view-jadwal', compact('jadwals', 'semester'));
    // }
    public function viewJadwal($id)
    {
        // Ambil data jadwal berdasarkan id_jadwal
        $jadwal = Jadwal::with('tahunAjaran') // Mengambil relasi tahun ajaran
                        ->findOrFail($id); // Pastikan id ditemukan
    
        return view('kaprodi.view-jadwal', compact('jadwal'));
    }
    // public function viewJadwal($id)
    // {
    //     // Ambil data jadwal berdasarkan id_jadwal
    //     $jadwal = Jadwal::with('tahunAjaran')->find($id);

    //     if (!$jadwal) {
    //         return redirect()->route('manajemen-jadwal-kaprodi.index')
    //                         ->with('error', 'Jadwal tidak ditemukan!');
    //     }

    //     // Cek apakah tahunAjaran tersedia
    //     if (!$jadwal->tahunAjaran) {
    //         return redirect()->route('manajemen-jadwal-kaprodi.index')
    //                         ->with('error', 'Tahun ajaran tidak ditemukan untuk jadwal ini!');
    //     }

    //     return view('kaprodi.view-jadwal', compact('jadwal'));
    // }


    // Fungsi untuk mengedit jadwal
    public function editJadwal(Request $request)
    {
        // Ambil semester dan section dari query string
        $semester = $request->query('semester', 'ganjil');

        // Ambil data mata kuliah berdasarkan plot_semester
        $mataKuliah = MataKuliah::where('plot_semester', $semester)->get();

        // Ambil jadwal berdasarkan kode_mk dari mata kuliah yang sesuai
        $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
                         ->get();

        return view('kaprodi.edit-jadwal', compact('jadwals', 'semester'));
    }

    // Apply jadwal (mengajukan untuk disetujui)
    public function applyJadwal(Request $request)
    {
        // Ambil semester dari query string
        $semester = $request->query('semester', 'ganjil');

        // Ambil data mata kuliah berdasarkan plot_semester
        $mataKuliah = MataKuliah::where('plot_semester', $semester)->get();

        // Ambil jadwal berdasarkan kode_mk dari mata kuliah yang sesuai
        $jadwals = Jadwal::whereIn('kode_mk', $mataKuliah->pluck('kode_mk'))
                         ->get();

        // Proses pengajuan jadwal untuk disetujui (misalnya, mengubah status jadi 'pending')
        foreach ($jadwals as $item) {
            $item->status = 'pending';  // Mengubah status menjadi 'pending'
            $item->save();
        }

        // Redirect ke halaman manajemen jadwal dengan pesan sukses
        return redirect()->route('manajemen-jadwal-kaprodi.index', ['semester' => $semester])
                         ->with('success', 'Jadwal berhasil diajukan untuk disetujui!');
    }

    
    
    // }
    public function dashboard()
    {
        return view('kaprodi/dashboard-kaprodi');
    }


    // public function manajemenJadwal()
    // {
    //     return view('kaprodi/manajemen-jadwal-kaprodi');
    // }

    
    public function index(Request $request)
    {
        $semester = $request->get('semester', 'ganjil'); // Default semester ganjil
        $semesters = $semester == 'ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];
        $section = $request->get('section', null); // Misalnya untuk membedakan bagian yang sedang aktif
        
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('semester', 'section', 'semesters'));
    }

    // FIXXX
    // Fungsi untuk menampilkan jadwal
    // public function viewJadwal(Request $request)
    // {
    //     $semester = $request->query('semester', 'ganjil');
    //     $section = $request->query('section', 'semester1'); // Atau sesuai dengan parameter section yang kamu butuhkan

    //     // Ambil data jadwal berdasarkan semester dan section
    //     $jadwal = Jadwal::where('semester', $semester)
    //                     ->where('section', $section)
    //                     ->get();

    //     // Kirim data jadwal ke view
    //     return view('kaprodi.view-jadwal', compact('jadwal'));
    // }

    // // Fungsi untuk mengedit jadwal
    // public function editJadwal(Request $request)
    // {
    //     $semester = $request->query('semester', 'ganjil');
    //     $section = $request->query('section', 'semester1'); // Atau sesuai dengan parameter section yang kamu butuhkan

    //     // Ambil data jadwal berdasarkan semester dan section
    //     $jadwal = Jadwal::where('semester', $semester)
    //                     ->where('section', $section)
    //                     ->first();  // Ambil satu jadwal untuk diedit

    //     return view('kaprodi.edit-jadwal', compact('jadwal'));
    // }

    // // Fungsi untuk apply jadwal
    // public function applyJadwal(Request $request)
    // {
    //     $semester = $request->query('semester', 'ganjil');
    //     $section = $request->query('section', 'semester1'); // Atau sesuai dengan parameter section yang kamu butuhkan

    //     // Ambil data jadwal berdasarkan semester dan section
    //     $jadwal = Jadwal::where('semester', $semester)
    //                     ->where('section', $section)
    //                     ->get();

    //     // Logika untuk apply jadwal
    //     // Misalnya update status jadwal atau hal lainnya sesuai kebutuhan

    //     return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diterapkan!');
    // }
    // Fungsi untuk menampilkan form edit jadwal
    // public function editJadwal($id)
    // {
    //     $jadwal = Jadwal::findOrFail($id);
    //     $dosens = Dosen::all(); // Data dosen
    //     $ruangs = Ruang::all(); // Data ruang
    //     $matakuliahs = Matakuliah::all(); // Data matakuliah

    //     return view('kaprodi.edit-jadwal', compact('jadwal', 'dosens', 'ruangs', 'matakuliahs'));
    // }

    // // Fungsi untuk memperbarui data jadwal
    // public function updateJadwal(Request $request, $id)
    // {
    //     $request->validate([
    //         'kode_mk' => 'required',
    //         'kelas' => 'required',
    //         'hari' => 'required',
    //         'waktu_mulai' => 'required',
    //         'waktu_selesai' => 'required',
    //         'id_ruang' => 'required',
    //         'dosen_pengampu' => 'required',
    //     ]);

    //     $jadwal = Jadwal::findOrFail($id);
    //     $jadwal->kode_mk = $request->kode_mk;
    //     $jadwal->kelas = $request->kelas;
    //     $jadwal->hari = $request->hari;
    //     $jadwal->waktu_mulai = $request->waktu_mulai;
    //     $jadwal->waktu_selesai = $request->waktu_selesai;
    //     $jadwal->id_ruang = $request->id_ruang;
    //     $jadwal->nind = $request->dosen_pengampu;
    //     $jadwal->save();

    //     return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diperbarui!');
    // }
    // Menampilkan halaman manajemen jadwal
    // public function index()
    // {
    //     $jadwal = Jadwal::with(['ruang', 'matakuliah', 'dosen', 'tahunAjaran'])->get();
    //     return view('kaprodi.manajemen-jadwal-kaprodi', compact('jadwal'));
    // }

    // Menampilkan form tambah jadwal
    public function create()
    {
        $dosens = Dosen::all();
        $ruangs = Ruang::all();
        $matakuliahs = Matakuliah::all();
        $tahunAjarans = TahunAjaran::all();

        return view('kaprodi.create-jadwal', compact('dosens', 'ruangs', 'matakuliahs', 'tahunAjarans'));
    }

    // Menyimpan jadwal baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'nidn' => 'required',
            'kode_mk' => 'required',
            'id_ruang' => 'required',
            'id_tahunajaran' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // Menghapus jadwal
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    // public function monitoring()
    // {
    //     return view('kaprodi/monitoring-kaprodi');
    // } 
    public function monitoring()
    {
        // Dummy data
        // $data = [
        //     [
        //         'id' => 1,
        //         'nama_pembimbing' => 'Udin Saripudin, S.Kom, M.Cs',
        //         'jumlah_isi' => 20,
        //         'total_mahasiswa' => 40,
        //         'persentase' => 50,
        //     ],
        //     [
        //         'id' => 2,
        //         'nama_pembimbing' => 'Dr. Eng. Adi Wibowo, S.Si, M.Kom.',
        //         'jumlah_isi' => 40,
        //         'total_mahasiswa' => 40,
        //         'persentase' => 100,
        //     ],
        // ];

        // return view('kaprodi.monitoring-kaprodi', compact('data'));
        
        
        // Mengambil semua data monitoring
        $data = Monitoring::all();

        // Menampilkan data ke view
        return view('kaprodi.monitoring-kaprodi', compact('data'));
    }

    public function viewMonitoring($id)
    {
        // Contoh data monitoring yang ditampilkan
        return "Viewing monitoring data for ID: $id";
    }

}


