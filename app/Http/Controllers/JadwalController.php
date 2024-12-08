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
                    ->get();
        //dd($jadwals); 

        return view('jadwal.view', compact('jadwals',  'prodi', 'tahun_ajaran', 'id_tahun', 'id_prodi'));
    }
    
    // Menampilkan form untuk menambah jadwal
    public function create(Request $request)
    {
        $id_tahun = $request->query('id_tahun');
        $id_prodi = $request->query('id_prodi');

        if (!$id_tahun || !$id_prodi) {
            return redirect()->route('jadwal.index')->withErrors('id_tahun atau id_prodi tidak ditemukan');
        }

        // Ambil matakuliah - Asumsi matakuliah semua bisa dipilih atau Anda bisa filter sesuai prodi
        $matakuliah = Matakuliah::all();

        // Ambil ruang yang disetujui dari usulan_ruang_kuliah
        $ruang = DB::table('usulan_ruang_kuliah')
            ->join('ruang', 'usulan_ruang_kuliah.id_ruang', '=', 'ruang.id_ruang')
            ->where('usulan_ruang_kuliah.id_prodi', $id_prodi)
            ->where('usulan_ruang_kuliah.id_tahun', $id_tahun)
            ->where('usulan_ruang_kuliah.status', 'disetujui')
            ->select('ruang.id_ruang')
            ->get();

        return view('jadwal.create', compact('matakuliah', 'ruang', 'id_tahun', 'id_prodi'));
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
        $request->validate([
            'kode_mk' => 'required',
            'kelas' => 'required',
            'id_ruang' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'kuota' => 'required',
        ]);

        $id_tahun = $request->id_tahun;
        $id_prodi = $request->id_prodi;

        // Cek bentrok jadwal
        $hari = $request->hari;
        $id_ruang = $request->id_ruang;
        $waktu_mulai = $request->waktu_mulai;
        $waktu_selesai = $request->waktu_selesai;

        $conflict = Jadwal::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->where('hari', $hari)
            ->where('id_ruang', $id_ruang)
            ->where(function($query) use ($waktu_mulai, $waktu_selesai) {
                $query->where(function($q) use ($waktu_mulai, $waktu_selesai) {
                    // Jadwal lama dimulai sebelum jadwal baru selesai
                    // dan jadwal lama selesai setelah jadwal baru mulai
                    $q->where('waktu_mulai', '<', $waktu_selesai)
                    ->where('waktu_selesai', '>', $waktu_mulai);
                });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors('Terjadi bentrok jadwal. Silakan pilih waktu atau ruang lain.');
        }

        // Generate ID Jadwal baru
        $lastJadwal = Jadwal::where('id_tahun', $id_tahun)
                            ->where('id_prodi', $id_prodi)
                            ->orderBy('id_jadwal', 'desc')
                            ->first();
        $lastId = $lastJadwal ? (int) substr($lastJadwal->id_jadwal, -3) : 100;
        $newId = $id_tahun . $id_prodi . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        Jadwal::create([
            'id_jadwal' => $newId,
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

        return redirect()->route('jadwal.view', ['id_tahun' => $id_tahun, 'id_prodi' => $id_prodi])->with('success', 'Jadwal berhasil dibuat!');
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

    // Fungsi untuk mengajukan jadwal ke Dekan
    public function ajukanJadwal($id_tahun, $id_prodi)
    {
        // Cari jadwal yang sesuai dengan id_tahun dan id_prodi
        $jadwals = Jadwal::where('id_tahun', $id_tahun)
                         ->where('id_prodi', $id_prodi)
                         ->get();

        // Lakukan logika pengajuan jadwal ke Dekan
        foreach ($jadwals as $jadwal) {
            // Misalnya kita menambahkan status atau flag 'ajukan' ke jadwal
            $jadwal->status = 'Diajukan ke Dekan';
            $jadwal->save();
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('jadwal.index', ['id_tahun' => $id_tahun, 'id_prodi' => $id_prodi])
                         ->with('success', 'Jadwal telah diajukan ke Dekan.');
    }


    public function edit($id)
    {
        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            return redirect()->back()->withErrors('Jadwal tidak ditemukan.');
        }

        $id_tahun = $jadwal->id_tahun;
        $id_prodi = $jadwal->id_prodi;

        $matakuliah = Matakuliah::all();

        // Ambil ruang yang disetujui
        $ruang = DB::table('usulan_ruang_kuliah')
            ->join('ruang', 'usulan_ruang_kuliah.id_ruang', '=', 'ruang.id_ruang')
            ->where('usulan_ruang_kuliah.id_prodi', $id_prodi)
            ->where('usulan_ruang_kuliah.id_tahun', $id_tahun)
            ->where('usulan_ruang_kuliah.status', 'disetujui')
            ->select('ruang.id_ruang')
            ->get();

        return view('jadwal.edit', compact('jadwal', 'matakuliah', 'ruang'));
    }

    // Mengupdate jadwal yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mk' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'id_ruang' => 'required',
            'kuota' => 'required|integer',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $id_tahun = $jadwal->id_tahun;
        $id_prodi = $jadwal->id_prodi;

        $hari = $request->hari;
        $id_ruang = $request->id_ruang;
        $waktu_mulai = $request->waktu_mulai;
        $waktu_selesai = $request->waktu_selesai;

        // Cek bentrok jadwal (kecuali jadwal yang sedang di-update)
        $conflict = Jadwal::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->where('hari', $hari)
            ->where('id_ruang', $id_ruang)
            ->where('id_jadwal', '!=', $jadwal->id_jadwal)
            ->where(function($query) use ($waktu_mulai, $waktu_selesai) {
                $query->where(function($q) use ($waktu_mulai, $waktu_selesai) {
                    $q->where('waktu_mulai', '<', $waktu_selesai)
                    ->where('waktu_selesai', '>', $waktu_mulai);
                });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors('Terjadi bentrok jadwal. Silakan pilih waktu atau ruang lain.');
        }

        $jadwal->update([
            'kode_mk' => $request->kode_mk,
            'kelas' => $request->kelas,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'id_ruang' => $request->id_ruang,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('jadwal.view', ['id_tahun' => $id_tahun, 'id_prodi' => $id_prodi])->with('success', 'Jadwal berhasil diperbarui!');
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
    
    public function checkConflict(Request $request) {
        $id_tahun = $request->input('id_tahun');
        $id_prodi = $request->input('id_prodi');
        $id_ruang = $request->input('id_ruang');
        $hari = $request->input('hari');
        $waktu_mulai = $request->input('waktu_mulai');
        $waktu_selesai = $request->input('waktu_selesai');
        $id_jadwal = $request->input('id_jadwal'); // optional jika untuk edit
    
        // Query untuk mengecek bentrok:
        // Misal logika bentrok: jadwal lain di ruang sama, hari sama, dan jam overlap
        $query = DB::table('jadwal')
            ->where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->where('id_ruang', $id_ruang)
            ->where('hari', $hari);
    
        // Jika sedang edit, exclude jadwal sekarang
        if ($id_jadwal) {
            $query->where('id_jadwal', '!=', $id_jadwal);
        }
    
        // Cek overlap waktu: (waktu_mulai < jadwal_lain.waktu_selesai) AND (waktu_selesai > jadwal_lain.waktu_mulai)
        $bentrok = $query->where(function($q) use ($waktu_mulai, $waktu_selesai) {
            $q->where('waktu_mulai', '<', $waktu_selesai)
              ->where('waktu_selesai', '>', $waktu_mulai);
        })->exists();
    
        return response()->json(['conflict' => $bentrok]);
    }
    
    public function checkDuplicate(Request $request)
    {
        $id_tahun = $request->input('id_tahun');
        $id_prodi = $request->input('id_prodi');
        $kode_mk = $request->input('kode_mk');
        $kelas = $request->input('kelas');
        $id_jadwal = $request->input('id_jadwal'); // optional jika untuk edit

        $query = DB::table('jadwal')
            ->where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->where('kode_mk', $kode_mk)
            ->where('kelas', $kelas);

        // Jika edit, exclude jadwal saat ini
        if ($id_jadwal) {
            $query->where('id_jadwal', '!=', $id_jadwal);
        }

        $exists = $query->exists();

        return response()->json(['duplicate' => $exists]);
    }



    // public function manajemenJadwal(Request $request)
    // {
    //     // Ambil data tahun ajaran dan program studi
    //     $tahunAjarans = TahunAjaran::all();
    //     $prodis = ProgramStudi::all();  // Mengambil semua program studi
    //     $id_tahun = $request->query('id_tahun');
    //     $id_prodi = $request->query('id_prodi');

    //     // Ambil data jadwal berdasarkan id_tahun dan id_prodi
    //     $jadwals = Jadwal::where('id_tahun', $id_tahun)
    //                      ->where('id_prodi', $id_prodi)
    //                      ->get();

    //     // Mengirim data ke view
    //     return view('kaprodi.manajemen-jadwal-kaprodi', compact('tahunAjarans', 'prodis', 'jadwals', 'id_tahun', 'id_prodi'));
    // }
    // public function kaprodi(Request $request)
    // {
    //     // Ambil data Tahun Ajaran dan Program Studi untuk dropdown
    //     $tahunajarans = TahunAjaran::all();
    //     $prodis = ProgramStudi::all();

    //     // Ambil jadwal berdasarkan filter id_tahun dan id_prodi
    //     $jadwals = Jadwal::with(['prodi', 'tahunAjaran', 'matakuliah', 'ruang'])
    //                     ->where('id_tahun', $request->input('id_tahun'))
    //                     ->where('id_prodi', $request->input('id_prodi'))
    //                     ->get();

    //     // Return view dengan data jadwal dan pilihan tahun ajaran dan prodi
    //     return view('manajemen-jadwal-kaprodi', compact('jadwals', 'tahun_ajaran', 'prodi'));
    // }   

    // public function dashboard() { 
    //     $currentYear = TahunAjaran::orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc')->first(); 
    //     if (!$currentYear) { 
    //         return redirect()->route('dashboard.kaprodi')->with('error', 'Tahun Ajaran belum tersedia.'); 
    //     } 
    //     $jumlahRuang = Jadwal::distinct('id_ruang')->count('id_ruang'); 
    //     $jumlahDosen = 30; // Misal data dari tabel dosen 
    //     $jumlahMahasiswa = 200; // Misal data dari tabel mahasiswa 
    //     $jumlahMataKuliah = Jadwal::where('id_tahun', $currentYear->id)->distinct('kode_mk')->count('kode_mk'); 
    //     $statusPenyusunan = [ 
    //         'scheduled' => Jadwal::where('id_tahun', $currentYear->id)->count(), 
    //         'not_scheduled' => 100 - Jadwal::where('id_tahun', $currentYear->id)->count() // Misal total 100 MK 
    //     ]; 
    //     return view('kaprodi.dashboard', compact('jumlahRuang', 'jumlahDosen', 'jumlahMahasiswa', 'jumlahMataKuliah', 'statusPenyusunan', 'currentYear'));
    // }
    

}

