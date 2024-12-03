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
    public function manajemenJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan semester
        $tahunAjarans = TahunAjaran::all();
        $id_tahun = $request->query('id_tahun');
        $semester = $request->query('semester');
    
        // Tentukan semester berdasarkan digit terakhir id_tahun (ganjil/genap)
        $lastDigit = substr($id_tahun, -1);
        $semesterType = ($lastDigit == '1') ? 'ganjil' : 'genap';
    
        // Tentukan daftar semester berdasarkan jenisnya (ganjil/genap)
        $semesterNumbers = ($semesterType === 'ganjil') ? [1, 3, 5, 7] : [2, 4, 6, 8];
    
        // Ambil data jadwal dengan relasi ke matakuliah dan filter berdasarkan semester
        $jadwals = Jadwal::with('matakuliah')
                         ->where('id_tahun', $id_tahun)
                         ->whereHas('matakuliah', function($query) use ($semesterNumbers) {
                             $query->whereIn('plot_semester', $semesterNumbers); // Filter berdasarkan semester ganjil/genap
                         })
                         ->get();
    
        // Debugging: Periksa data yang dikirimkan
        //dd($jadwals);  // Cek apakah $jadwals berisi data yang sesuai
    
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'jadwals', 'semesterType', 'id_tahun', 'semester'));
        
    }
    
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



    
    public function index(Request $request)
    {
        $semester = $request->get('semester', 'ganjil'); // Default semester ganjil
        $semesters = $semester == 'ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];
        $section = $request->get('section', null); // Misalnya untuk membedakan bagian yang sedang aktif
        
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('semester', 'section', 'semesters'));
    }

    
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
        'kode_mk' => 'required',
        'id_ruang' => 'required',
        'id_tahun' => 'required',
        'id_prodi' => 'required',
        'kuota' => 'required|integer',  // Validasi kuota
    ]);

    Jadwal::create([
        'kelas' => $request->kelas,
        'hari' => $request->hari,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'kode_mk' => $request->kode_mk,
        'id_ruang' => $request->id_ruang,
        'id_tahun' => $request->id_tahun,
        'id_prodi' => $request->id_prodi,
        'kuota' => $request->kuota,  // Mengisi kolom kuota
    ]);

    return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil ditambahkan!');
}

    // Menghapus jadwal
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil dihapus!');
    }


    public function monitoring()
    {

        $data = [
            [
                'id' => 1,
                'nama_pembimbing' => 'Udin Saripudin, S.Kom, M.Cs',
                'jumlah_isi' => 20,
                'total_mahasiswa' => 40,
                'persentase' => 50,
            ],
            [
                'id' => 2,
                'nama_pembimbing' => 'Dr. Eng. Adi Wibowo, S.Si, M.Kom.',
                'jumlah_isi' => 40,
                'total_mahasiswa' => 40,
                'persentase' => 100,
            ],
        ];

        return view('kaprodi.monitoring-kaprodi', compact('data'));
        
        
        // // Mengambil semua data monitoring
        // $data = Monitoring::all();

        // // Menampilkan data ke view
        // return view('kaprodi.monitoring-kaprodi', compact('data'));
    }

    public function viewMonitoring($id)
    {
        // Contoh data monitoring yang ditampilkan
        return "Viewing monitoring data for ID: $id";
    }

}


