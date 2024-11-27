<?php
namespace App\Http\Controllers;
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\TahunAjaran;
use App\Models\Jadwal;
use Illuminate\Http\Request;


class KaprodiController extends Controller
{
    public function manajemenJadwal(Request $request)
    {
        $id_tahun = $request->query('id_tahun', '2023G'); // Default tahun
        $tahun = TahunAjaran::where('id_tahun', $id_tahun)->first();
    
        if (!$tahun) {
            return redirect()->back()->with('error', 'Tahun ajaran tidak ditemukan.');
        }
    
        $semesters = [1, 3, 5, 7]; // Daftar semester yang ditampilkan
    
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahun', 'semesters', 'id_tahun'));
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
        $section = $request->get('section', null);
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('semester','section', 'semesters'));
    }
    // Fungsi untuk menampilkan form edit jadwal
    public function editJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $dosens = Dosen::all(); // Data dosen
        $ruangs = Ruang::all(); // Data ruang
        $matakuliahs = Matakuliah::all(); // Data matakuliah

        return view('kaprodi.edit-jadwal', compact('jadwal', 'dosens', 'ruangs', 'matakuliahs'));
    }

    // Fungsi untuk memperbarui data jadwal
    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'kode_mk' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'id_ruang' => 'required',
            'dosen_pengampu' => 'required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->kode_mk = $request->kode_mk;
        $jadwal->kelas = $request->kelas;
        $jadwal->hari = $request->hari;
        $jadwal->waktu_mulai = $request->waktu_mulai;
        $jadwal->waktu_selesai = $request->waktu_selesai;
        $jadwal->id_ruang = $request->id_ruang;
        $jadwal->nind = $request->dosen_pengampu;
        $jadwal->save();

        return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
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
    }

    public function viewMonitoring($id)
    {
        // Contoh data monitoring yang ditampilkan
        return "Viewing monitoring data for ID: $id";
    }

    public function editMonitoring($id)
    {
        // Contoh edit monitoring
        return "Editing monitoring data for ID: $id";
    }

    public function deleteMonitoring($id)
    {
        // Contoh hapus monitoring
        return "Deleting monitoring data for ID: $id";
    }

    public function konsultasi()
    {
        return view('kaprodi/konsultasi-kaprodi');
    }


    
}


