<?php

namespace App\Http\Controllers;

use App\Models\irs;
use App\Models\dosen;
use App\Models\jadwal;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Clone_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    
    public function showAll()
    {
        $nidn = session('nidn');
        
        // Ambil data dosen beserta jumlah mahasiswa perwalian
        $dosen = dosen::withCount('mahasiswa')->where('nidn', $nidn)->first();
        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();
        
        $query = DB::table('mahasiswa as m')
        ->distinct()
        ->where('nidn', '=', $nidn)
        ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
        ->select(
            'm.nim',
            'm.nama',
            'm.semester'
        )
        ->groupBy('m.nim');
       
        
        // @dd($query->whereNull('i.nim')->get()->count());
        $belum_irs = (clone $query)->whereNull('i.nim')->get()->count();
        $belum_disetujui = (clone $query)->whereNotNull('i.nim')->whereNull('i.tanggal_disetujui')->get()->count();
        $sudah_disetujui = (clone $query)->whereNotNull('i.nim')->whereNotNull('i.tanggal_disetujui')->get()->count();
    

        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }
        
        // Kirim data ke view
        return view('doswal/dashboard-doswal', compact('dosen', 'tahun', 'belum_irs', 'belum_disetujui', 'sudah_disetujui'));
    }
    
    public function showPersetujuan()
    {
        $nidn = session('nidn');
        // Ambil data dosen beserta jumlah mahasiswa perwalian
        $dosen = dosen::withCount('mahasiswa')->where('nidn', $nidn)->first();

        $mhs_filter = DB::table('mahasiswa as m')
        ->distinct()
        ->where('m.nidn', '=', $nidn)
        ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
        ->select(
            'm.nim',
            'm.nama',
            'm.semester'
        )
        ->where(function ($query) {
            $query->whereNotNull('i.nim')
                ->whereNull('i.tanggal_disetujui')
                ->orWhere(function ($query) {
                    $query->whereNotNull('i.nim')
                            ->whereNotNull('i.tanggal_disetujui');
                });
        })
        ->orderBy('nama')
        ->get();

        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();
        
        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }
        
        // Kirim data ke view
        return view('doswal/persetujuanIRS-doswal', compact('dosen', 'tahun', 'mhs_filter'));
    }
    
    public function showRekap()
    {
        $nidn = session('nidn');

        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();
        
        // Ambil data dosen beserta jumlah mahasiswa perwalian
        $dosen = dosen::with('mahasiswa')->where('nidn', $nidn)->first();

        // ambil 
        $result = DB::table('mahasiswa as m')
        ->distinct()
        ->where('nidn','=',$nidn)
        ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
        ->select(
            'm.nim',
            'm.nama',
            'm.semester',
            DB::raw("CASE
                WHEN i.nim IS NULL THEN 'Belum IRS'
                WHEN i.tanggal_disetujui IS NULL THEN 'Belum Disetujui'
                ELSE 'Sudah disetujui'
            END AS status")
        )
        ->get();

        if (!$dosen) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }

        // Kirim data ke view
        return view('doswal/rekap-doswal', compact('dosen', 'result', 'tahun'));
    }


    public function showInformasi ($nim){
        // ambil nidn
        $nidn = session('nidn');

        // Ambil data dosen
        $dosen = dosen::all()->where('nidn', $nidn)->first();

        // ambil data mahasiswa terpilih
        $result = DB::table('mahasiswa as m')
        ->distinct()
        ->where('nidn','=',$nidn)
        ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
        ->select(
            'm.nim',
            'm.nama',
            'm.semester',
            DB::raw("CASE
                WHEN i.nim IS NULL THEN 'Belum IRS'
                WHEN i.tanggal_disetujui IS NULL THEN 'Belum Disetujui'
                ELSE 'Sudah disetujui'
            END AS status")
        )
        ->where('m.nim',$nim)
        ->first();

        // ambil data jadwal 
        $irs = DB::table('irs as i')
        ->distinct()
        ->where('i.nim', '=', $nim)
        ->join('jadwal as j', 'i.id_jadwal', '=', 'j.id_jadwal')
        ->join('ruang as r', 'r.id_ruang', '=', 'j.id_ruang')
        ->join('matakuliah as m', 'j.kode_mk', '=', 'm.kode_mk')
        ->join('tahun_ajaran as ta', 'j.id_tahun', '=', 'ta.id_tahun')
        ->select(
            'm.kode_mk',
            'm.nama',
            'm.sks',
            'j.kelas',
            'r.id_ruang',
            'i.status',
            'ta.tahun_ajaran',
            DB::raw("
                CASE j.hari
                    WHEN 1 THEN 'Senin'
                    WHEN 2 THEN 'Selasa'
                    WHEN 3 THEN 'Rabu'
                    WHEN 4 THEN 'Kamis'
                    WHEN 5 THEN 'Jumat'
                    WHEN 6 THEN 'Sabtu'
                    WHEN 7 THEN 'Minggu'
                    ELSE 'Tidak Diketahui'
                END AS hari
            "),
            'j.waktu_mulai',
            'j.waktu_selesai',
        )
        ->get();

        $sum_sks = $irs->sum('sks');
    
        return view('doswal/informasi-irs-doswal', compact('dosen', 'result', 'irs', 'sum_sks'));
    }

    public function showInformasiLite ($nim){
        // ambil nidn
        $nidn = session('nidn');

        // ambil tahun ajaran
        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();
        
        // Ambil data dosen
        $dosen = dosen::all()->where('nidn', $nidn)->first();

        // ambil data mahasiswa terpilih
        $result = DB::table('mahasiswa as m')
        ->distinct()
        ->where('nidn','=',$nidn)
        ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
        ->select(
            'm.nim',
            'm.nama',
            'm.semester',
            DB::raw("CASE
                WHEN i.nim IS NULL THEN 'Belum IRS'
                WHEN i.tanggal_disetujui IS NULL THEN 'Belum Disetujui'
                ELSE 'Sudah disetujui'
            END AS status")
        )
        ->where('m.nim',$nim)
        ->first();

        // ambil data jadwal 
        $irs_now = DB::table('irs as i')
        ->distinct()
        ->where('i.nim', '=', $nim)
        ->join('jadwal as j', 'i.id_jadwal', '=', 'j.id_jadwal')
        ->join('ruang as r', 'r.id_ruang', '=', 'j.id_ruang')
        ->join('matakuliah as m', 'j.kode_mk', '=', 'm.kode_mk')
        ->join('tahun_ajaran as ta', 'j.id_tahun', '=', 'ta.id_tahun')
        ->where('i.nim', '=', $nim)
        ->select(
            'm.kode_mk',
            'm.nama',
            'm.sks',
            'j.kelas',
            'r.id_ruang',
            'i.status',
            'ta.tahun_ajaran',
            DB::raw("
                CASE j.hari
                    WHEN 1 THEN 'Senin'
                    WHEN 2 THEN 'Selasa'
                    WHEN 3 THEN 'Rabu'
                    WHEN 4 THEN 'Kamis'
                    WHEN 5 THEN 'Jumat'
                    WHEN 6 THEN 'Sabtu'
                    WHEN 7 THEN 'Minggu'
                    ELSE 'Tidak Diketahui'
                END AS hari
            "),
            'j.waktu_mulai',
            'j.waktu_selesai',
        );

        $irs = $irs_now->where('j.id_tahun', '=', '20242')->get();

        $sum_sks = $irs->sum('sks');
    
        return view('doswal/informasi-irs-doswal-fromPersetujuan', compact('dosen', 'tahun', 'result', 'irs', 'sum_sks'));
    }
}
