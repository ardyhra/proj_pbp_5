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
    
    public function checkConflict(Request $request)
    {
        $id_tahun = $request->input('id_tahun');
        $id_prodi = $request->input('id_prodi');
        $hari = $request->input('hari');
        $id_ruang = $request->input('id_ruang');
        $waktu_mulai = $request->input('waktu_mulai');
        $waktu_selesai = $request->input('waktu_selesai');
        $kode_mk = $request->input('kode_mk'); // Pastikan kode_mk juga dikirim saat AJAX check-conflict
        $id_jadwal = $request->input('id_jadwal'); // jika dalam edit mode, agar tidak dibandingkan dengan dirinya sendiri

        // Query untuk cek bentrok ruang berdasarkan hari, ruang, dan waktu
        $bentrokRuang = Jadwal::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->where('hari', $hari)
            ->where(function($query) use ($waktu_mulai, $waktu_selesai) {
                $query->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai])
                    ->orWhere(function($q) use ($waktu_mulai, $waktu_selesai) {
                        $q->where('waktu_mulai', '<=', $waktu_mulai)
                            ->where('waktu_selesai', '>=', $waktu_selesai);
                    });
            })
            ->where(function($query) use ($id_ruang, $kode_mk) {
                // Disini cek bentrok ruang DAN bentrok mk
                // Bentrok ruang:
                $query->where('id_ruang', $id_ruang)
                    ->orWhere('kode_mk', $kode_mk);
            });

        // Jika edit, exclude jadwal ini sendiri
        if (!empty($id_jadwal)) {
            $bentrokRuang->where('id_jadwal', '!=', $id_jadwal);
        }

        $conflictExists = $bentrokRuang->exists();

        return response()->json(['conflict' => $conflictExists]);
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
}

