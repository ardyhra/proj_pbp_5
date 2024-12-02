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

}
