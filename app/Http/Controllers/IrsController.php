<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\dosen;
use App\Models\irs;
use App\Models\mahasiswa;
use App\Models\Jadwal;
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
                'irs.tanggal_disetujui',
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
            $key = $ir->kode_mk . '_' . $ir->kelas; // Kunci berdasarkan kode MK dan kelas
            
            if (!isset($array_irs[$key])) {
                $array_irs[$key] = [
                    'status' => $ir->status,
                    'tanggal_disetujui' => $ir->tanggal_disetujui,
                    'hari_waktu' => [], // Untuk menyimpan kombinasi hari dan waktu
                    'kelas' => $ir->kelas,
                    'id_ruang' => $ir->id_ruang,
                    'kode_mk' => $ir->kode_mk,
                    'nama_mk' => $ir->nama_mk,
                    'sks' => $ir->sks,
                    'dosen' => [] // Menyimpan dosen sebagai array
                ];
            }
            
            // Format waktu menjadi 5 karakter (hh:mm)
            $waktuMulai = substr($ir->waktu_mulai, 0, 5);
            $waktuSelesai = substr($ir->waktu_selesai, 0, 5);
            
            // Tambahkan kombinasi hari dan waktu jika belum ada
            $hariWaktu = $ir->hari . ', ' . $waktuMulai . '-' . $waktuSelesai;
            if (!in_array($hariWaktu, $array_irs[$key]['hari_waktu'])) {
                $array_irs[$key]['hari_waktu'][] = $hariWaktu;
            }

            // Tambahkan dosen jika belum ada
            if (!in_array($ir->nama, $array_irs[$key]['dosen'])) {
                $array_irs[$key]['dosen'][] = $ir->nama;
            }
        }
    
        // Ubah struktur hari_waktu menjadi string
        foreach ($array_irs as &$ir) {
            $ir['hari_waktu'] = implode('<br>', $ir['hari_waktu']);
        }

        // Mengembalikan data dalam format JSON
        return response()->json(['irs' => array_values($array_irs)]);
    }

    public function tambahMataKuliahIrs(Request $request)
    {
        $mahasiswa = Mahasiswa::find($request->nim);
        $idThn = $request->id_Tahun;
        $idJadwalList = $request->id_jadwal_list; // List of ID jadwal from request

        foreach ($idJadwalList as $id_jadwal) {
            $jadwal = Jadwal::find($id_jadwal);

            // Cek apakah mata kuliah dengan jadwal ini sudah terdaftar
            $existingIrs = Irs::where('nim', $mahasiswa->nim)
                            ->where('id_jadwal', $jadwal->id_jadwal)
                            ->first();

            if ($existingIrs) {
                continue; // Jika sudah terdaftar, skip ke jadwal berikutnya
            }

            $status = $this->tentukanStatusIrs($mahasiswa->nim, $jadwal->kode_mk, $idThn);
            $currentKuota = Irs::where('id_jadwal', $jadwal->id_jadwal)->count();
            $maxKuota = $jadwal->kuota;

            if ($currentKuota == $maxKuota) {
                $this->handleKuotaPenuh($mahasiswa, $jadwal);
            }

            // Menambahkan mata kuliah ke IRS
            $irs = new Irs();
            $irs->nim = $mahasiswa->nim;
            $irs->id_jadwal = $jadwal->id_jadwal;
            $irs->status = $status;
            $irs->save();
        }

        return response()->json(['message' => 'Mata kuliah berhasil didaftarkan.']);
    }

    private function tentukanStatusIrs($nim, $kode_mk, $idThn)
    {
        // Mengecek riwayat nilai mahasiswa
        $riwayatNilai = Irs::where('nim', $nim)
                            ->join('jadwal', 'jadwal.id_jadwal', '=', 'irs.id_jadwal')
                            ->where('jadwal.kode_mk', $kode_mk)
                            ->where('jadwal.id_tahun', 'NOT LIKE', $idThn)
                            ->orderBy('irs.id_jadwal', 'desc')
                            ->first();

        if (!$riwayatNilai) {
            return 'BARU';  // Belum pernah mengambil mata kuliah
        } else if ($riwayatNilai->nilai >= 60) {
            return 'PERBAIKAN';  // Sudah pernah mengambil dan lulus (≥ 60)
        } else {
            return 'MENGULANG';  // Sudah pernah mengambil tapi tidak lulus (< 60)
        }
    }

    private function handleKuotaPenuh(Mahasiswa $mahasiswa, Jadwal $jadwal)
    {
        // Ambil semua IRS yang terdaftar pada kelas yang sama
        $irss = Irs::where('id_jadwal', $jadwal->id_jadwal)->get();

        // Urutkan IRS berdasarkan prioritas mahasiswa
        $irss = $irss->sortBy(function ($irs) use ($jadwal) {
            $existingMahasiswa = Mahasiswa::find($irs->nim);
            return $this->getPrioritas($existingMahasiswa, $jadwal);
        });

        // Cari mahasiswa dengan prioritas lebih tinggi untuk dihapus
        foreach ($irss as $irs) {
            $existingMahasiswa = Mahasiswa::find($irs->nim);

            // Bandingkan prioritas
            if ($this->getPrioritas($mahasiswa, $jadwal) < $this->getPrioritas($existingMahasiswa, $jadwal)) {
                // Hapus IRS mahasiswa dengan prioritas lebih tinggi
                Irs::where('nim', $irs->nim)
                    ->where('id_jadwal', $irs->id_jadwal)
                    ->delete();
                return; // Hanya perlu menghapus satu mahasiswa
            }
        }
    }

    private function getPrioritas(Mahasiswa $mahasiswa, Jadwal $jadwal)
    {
        $jenisMataKuliah = $jadwal->matakuliah->jenis; // W = Wajib, P = Pilihan
        $semesterPlot = $jadwal->matakuliah->plot_semester;

        if ($jenisMataKuliah == 'W') {
            if ($mahasiswa->semester == $semesterPlot) {
                return 1; // WAJIB mengambil matkul di semester ini
            } elseif ($mahasiswa->semester > $semesterPlot) {
                // Cek status IRS mahasiswa
                $irsMhs = Irs::where('nim', $mahasiswa->nim)
                    ->join('jadwal', 'jadwal.id_jadwal', '=', 'irs.id_jadwal')
                    ->where('jadwal.kode_mk', $jadwal->kode_mk)
                    ->where('jadwal.id_tahun', 'NOT LIKE', $jadwal->id_tahun)
                    ->orderBy('irs.id_jadwal', 'desc')
                    ->first();
                    
                if ($irsMhs->nilai < 60) {
                    return 2; // Semester atas yang mengulang
                } else {
                    return 3; // Semester atas yang perbaikan
                }
            } elseif ($mahasiswa->semester < $semesterPlot) {
                return 4; // Semester bawah
            }
        } else {
            if ($mahasiswa->semester >= 5) {
                return 1; // Semester ≥ 5 (FCFS)
            } else {
                return 2; // Semester < 5
            }
        }
    }

    public function hapusMataKuliahIrs(Request $request)
    {
        $idJadwalList = $request->id_jadwal_list; // List of ID jadwal from request

        foreach ($idJadwalList as $id_jadwal) {
            $irs = Irs::where('nim', $request->nim)
                    ->where('id_jadwal', $id_jadwal)
                    ->delete();
        }

        return response()->json(['message' => 'Pendaftaran Mata Kuliah berhasil dibatalkan.']);
    }
}
