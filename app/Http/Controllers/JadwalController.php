<?php
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
                    ->orderBy('hari')
                    ->get();
        //dd($jadwals); 

        return view('jadwal.view', compact('jadwals',  'prodi', 'tahun_ajaran', 'id_tahun', 'id_prodi'));
    }
    
    // Menampilkan form untuk menambah jadwal
    public function create(Request $request)
    {
        // Cek jika id_tahun dan id_prodi ada di query string
        $id_tahun = $request->query('id_tahun'); // Pastikan menggunakan query() untuk menangkap parameter dari URL
        $id_prodi = $request->query('id_prodi');
        $matakuliah = Matakuliah::all();  // Ambil data matakuliah
        $ruang = Ruang::all();
        if (!$id_tahun || !$id_prodi) {
            return redirect()->route('jadwal.index')->withErrors('id_tahun atau id_prodi tidak ditemukan');
        }
        // Kirim data ke view
        return view('jadwal.create', compact('matakuliah', 'ruang','id_tahun', 'id_prodi'));
    }
    
    function generateIdJadwal($id_tahun, $id_prodi)
    {
        // Cari id_jadwal terakhir yang cocok dengan id_tahun dan id_prodi
        $lastJadwal = Jadwal::where('id_jadwal', $id_tahun)
                            ->where('id_prodi', $id_prodi)
                            ->orderBy('id_jadwal', 'desc')
                            ->first();

        // Jika tidak ada jadwal sebelumnya, mulai dari 101
        $nextNumber = $lastJadwal ? (intval(substr($lastJadwal->id_jadwal, -3)) + 1) : 101;

        // Format id_jadwal dengan menambahkan angka urut yang telah dihitung
        $nextId = $id_tahun . $id_prodi . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return $nextId;
    }


    //COBA STORE
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_mk' => 'required',
            'kelas' => 'required',
            'id_ruang' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kuota' => 'required',
        ]);

        // Ambil id_tahun dan id_prodi
        $id_tahun = $request->id_tahun;
        $id_prodi = $request->id_prodi;

        // Ambil ID terakhir yang ada di database berdasarkan id_tahun dan id_prodi
        $lastJadwal = Jadwal::where('id_tahun', $id_tahun)
                            ->where('id_prodi', $id_prodi)
                            ->orderBy('id_jadwal', 'desc')
                            ->first();

        // Generate ID Jadwal baru
        $lastId = $lastJadwal ? (int) substr($lastJadwal->id_jadwal, -3) : 100;  // ambil 3 digit terakhir
        $newId = $id_tahun . $id_prodi . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        // Simpan jadwal ke database
        Jadwal::create([
            'id_jadwal' => $newId,  // Gunakan ID baru yang sudah dihitung
            'id_tahun' => $id_tahun,
            'id_prodi' => $id_prodi,
            'kode_mk' => $request->kode_mk,
            'kelas' => $request->kelas,
            'id_ruang' => $request->id_ruang,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'kuota' => $request->kuota,
        ]);

        // Redirect ke halaman jadwal
        return redirect()->route('jadwal.view', [
            'id_tahun' => $id_tahun,
            'id_prodi' => $id_prodi
        ])->with('success', 'Jadwal berhasil dibuat!');
    }

    public function checkKodeMk(Request $request)
    {
        $matakuliah = Matakuliah::where('kode_mk', $request->kode_mk)->first();

        if ($matakuliah) {
            return response()->json([
                'exists' => true,
                'sks' => $matakuliah->sks,
            ]);
        } else {
            return response()->json([
                'exists' => false,
            ]);
        }
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
    
}

