<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IrsController extends Controller
{ 
    public function approve($nim)
    {

        // Update tanggal_disetujui dengan tanggal saat ini
        DB::table('irs')
            ->where('nim', $nim)
            ->update(['tanggal_disetujui' => Carbon::now()]);
            // ->update(['tanggal_disetujui' => '2014-11-29']);


        return redirect()->back()->with('success', 'IRS berhasil disetujui!');
    }

    public function izin($nim)
    {
        DB::table('irs')
            ->where('nim', $nim)
            ->update(['tanggal_disetujui' => null]);
            // ->update(['tanggal_disetujui' => '2014-11-29']);
        return redirect()->back()->with('success', 'IRS diizinkan untuk diubah');
    }

    public function filter(Request $request)
    {
        // Ambil filter dari request
        $filter = $request->input('filter', 'semua'); // Default: 'semua'
        // @dd($request->input('filter', 'semua'));

        $nidn = session('nidn');
        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();

        // Ambil data dosen beserta jumlah mahasiswa perwalian
        $dosen = dosen::with('mahasiswa')->where('nidn', $nidn)->first();

        // Query data berdasarkan filter
        $query = DB::table('mahasiswa as m')
            ->distinct()
            ->where('nidn', '=', $nidn)
            ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
            ->select(
                'm.nim',
                'm.nama',
                'm.semester',
                DB::raw("CASE
                    WHEN i.nim IS NULL THEN 'Belum IRS'
                    WHEN i.tanggal_disetujui IS NULL THEN 'Belum Disetujui'
                    ELSE 'Sudah Disetujui'
                END AS status")
            );

        // Terapkan filter
        if ($filter == 'belum-irs') {
            $query->whereNull('i.nim');
        } elseif ($filter == 'belum-disetujui') {
            $query->whereNotNull('i.nim')->whereNull('i.tanggal_disetujui');
        } elseif ($filter == 'sudah-disetujui') {
            $query->whereNotNull('i.nim')->whereNotNull('i.tanggal_disetujui');
        }

        // Ambil hasil query
        $result = $query->get();

        // Kirim data ke view
        return view('doswal/rekap-doswal', compact('result', 'dosen', 'tahun'));
    }

    public function filter_dashboard(Request $request)
    {
        // Ambil filter dari request
        $filter = $request->input('filter', 'semua');

        $nidn = session('nidn');
        $tahun = DB::table('tahun_ajaran')
        ->select('tahun_ajaran')
        ->orderByDesc('tahun_ajaran')
        ->first();

        // Ambil data dosen beserta jumlah mahasiswa perwalian
        $dosen = dosen::with('mahasiswa')->where('nidn', $nidn)->first();

        // Query data berdasarkan filter
        $filternim = DB::table('mahasiswa as m')
            ->where('m.nidn', '=', $nidn);
        $query = $filternim
            ->distinct()
            ->leftJoin('irs as i', 'm.nim', '=', 'i.nim')
            ->select(
                'm.nim',
                'm.nama',
                'm.semester',
                DB::raw("CASE
                    WHEN i.nim IS NULL THEN 'Belum IRS'
                    WHEN i.tanggal_disetujui IS NULL THEN 'Belum Disetujui'
                    ELSE 'Sudah Disetujui'
                END AS status")
            );

        // Terapkan filter
        if ($filter == 'belum-irs') {
            $query->whereNull('i.nim');
        } elseif ($filter == 'belum-disetujui') {
            $query->whereNotNull('i.nim')->whereNull('i.tanggal_disetujui');
        } elseif ($filter == 'sudah-disetujui') {
            $query->whereNotNull('i.nim')->whereNotNull('i.tanggal_disetujui');
        }

        // Ambil hasil query
        $result = $query->get();

        // Kirim data ke view
        return view('doswal/rekap-doswal', compact('result', 'dosen', 'filter', 'tahun'));
    }


    public function filter_semester(Request $request)
    {
        // ambil nidn
        $nidn = session('nidn');
        
        // Ambil data dosen
        $dosen = dosen::all()->where('nidn', $nidn)->first();

        // ambil nim dari request
        $nim = $request->query('nim');

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
        
        // Query data berdasarkan filter
        $irs_filter = DB::table('irs as i')
        ->distinct()
        ->where('i.nim', '=', $nim)
        ->join('jadwal as j', 'i.id_jadwal', '=', 'j.id_jadwal')
        ->join('ruang as r', 'r.id_ruang', '=', 'j.id_ruang')
        ->join('matakuliah as m', 'j.kode_mk', '=', 'm.kode_mk')
        ->select(
            'm.kode_mk',
            'm.nama',
            'm.sks',
            'j.kelas',
            'r.id_ruang',
            'i.status',
            'j.id_tahun',
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
           
        $irs_data = $irs_filter->get();
        $semester = $result->semester;

        // Ambil filter dari request
        $filter = intval($request->input('filter_semester'));


        $arr_tahun = ['20242', '20241', '20232', '20231', '20222', '20221', '20212', '20211', '20202', '20201'];

        dd($irs_filter->where('j.id_tahun', '=', '20221')->get());
        
        // Terapkan filter
        $irs = $irs_filter->where('j.id_tahun', '=', $arr_tahun[$semester-$filter])->get();


        $sum_sks = $irs->sum('sks');
        
      
        // Kirim data ke view
        return view('doswal/informasi-irs-doswal', compact('result', 'dosen', 'irs', 'sum_sks'));
    }


}
