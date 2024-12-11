<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\dosen;
use App\Models\irs;
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
            'm.nama_mk',
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
        $filter = intval($request->input('filter_semester', 1));


        $arr_tahun = ['20241', '20232', '20231', '20222', '20221', '20212', '20211', '20202', '20201'];

        // dd($irs_filter->where('j.id_tahun', '=', '20221')->get());
        
        // Terapkan filter
        $irs = $irs_filter->where('j.id_tahun', '=', $arr_tahun[$semester-$filter])->get();


        $sum_sks = $irs->sum('sks');
        
      
        // Kirim data ke view
        return view('doswal/informasi-irs-doswal', compact('result', 'dosen', 'irs', 'sum_sks'));
    }


    public function getIrsDetail(Request $request)
    {
        $nim = session('nim');
        $id_tahun = $request->id_tahun;

        // Ambil data IRS berdasarkan nim dan tahun ajaran yang dipilih
        $irs = irs::where('nim', $nim)
            ->join('jadwal', 'irs.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('matakuliah', 'jadwal.kode_mk', '=', 'matakuliah.kode_mk')
            ->join('pengampu', 'matakuliah.kode_mk', '=', 'pengampu.kode_mk')
            ->join('dosen', 'pengampu.nidn', '=', 'dosen.nidn')
            ->where('jadwal.id_tahun', $id_tahun)
            ->orderBy('jadwal.id_jadwal', 'asc')
            ->select(
                'irs.status',
                DB::raw("
                    CASE jadwal.hari
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
                'jadwal.waktu_mulai',
                'jadwal.waktu_selesai',
                'jadwal.kelas',
                DB::raw("
                    CASE jadwal.id_ruang
                        WHEN '0000' THEN 'Lapangan Stadion UNDIP'
                        ELSE jadwal.id_ruang
                    END AS id_ruang
                "),
                'matakuliah.kode_mk',
                'matakuliah.nama_mk',
                'matakuliah.sks',
                'dosen.nama')
            ->get();
            
        // Mengubah data $irs menjadi array dengan format yang diinginkan
        $array_irs = [];
        foreach ($irs as $ir) {
            // Periksa apakah mata kuliah sudah ada dalam array
            if (!isset($array_irs[$ir->kode_mk])) {
                // Jika mata kuliah belum ada dalam array, buat entri baru
                $array_irs[$ir->kode_mk] = [
                    'status' => $ir->status,
                    'hari' => $ir->hari,
                    'waktu_mulai' => $ir->waktu_mulai,
                    'waktu_selesai' => $ir->waktu_selesai,
                    'kelas' => $ir->kelas,
                    'id_ruang' => $ir->id_ruang,
                    'kode_mk' => $ir->kode_mk,
                    'nama_mk' => $ir->nama_mk,
                    'sks' => $ir->sks,
                    'dosen' => [] // Menyimpan dosen sebagai array
                ];
            }
            // Tambahkan dosen ke dalam array dosen
            $array_irs[$ir->kode_mk]['dosen'][] = $ir->nama;
        }

        // Mengembalikan data dalam format JSON
        return response()->json(['irs' => array_values($array_irs)]);
    }

    public function tambahIRS(Request $request)
    {
        // Validasi data yang diterima (optional)
        $request->validate([
            'matakuliah_terdaftar' => 'required|array',
            'matakuliah_terdaftar.*.nim' => 'required|string',
            'matakuliah_terdaftar.*.id_jadwal' => 'required|string',
            'matakuliah_terdaftar.*.status' => 'required|string',
        ]);

        // Menyimpan data IRS yang diterima
        $data = $request->input('matakuliah_terdaftar'); // Ambil array matakuliah_terdaftar

        // Insert data ke dalam tabel IRS
        try {
            foreach ($data as $item) {
                IRS::create([
                    'nim' => $item['nim'],
                    'id_jadwal' => $item['id_jadwal'],
                    'status' => $item['status'],
                ]);
            }
            return response()->json(['success' => true, 'message' => 'IRS berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

        // Kembalikan respon sukses
        return response()->json(['success' => true, 'message' => 'IRS berhasil disimpan!']);
    }
}
