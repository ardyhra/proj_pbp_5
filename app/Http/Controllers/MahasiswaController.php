<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\RiwayatStatus;
use App\Models\irs;
use App\Models\Jadwal; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $nim = session('nim');

        // Ambil data mahasiswa  dari database
        $mhs = Mahasiswa::where('nim', $nim)->first() ?? 'Unknown';

        if ($mhs) {
            $mhs->nama = ucwords(strtolower($mhs->nama));
        }

        $doswal = Mahasiswa::where('nim', $nim)
            ->join('dosen', 'dosen.nidn', '=', 'mahasiswa.nidn')
            ->first() ?? 'Tidak ada dosen wali';

        $tahun_ajaran = RiwayatStatus::where('nim', $nim)
            ->join('tahun_ajaran', 'riwayat_status.id_tahun', '=', 'tahun_ajaran.id_tahun')
            ->orderBy('tahun_ajaran.id_tahun', 'desc')
            ->value('tahun_ajaran.tahun_ajaran') ?? 'Tidak ada data';

        $ipk = irs::where('nim', $nim)
        ->join('jadwal', 'irs.id_jadwal', '=', 'jadwal.id_jadwal')
        ->join('matakuliah', 'jadwal.kode_mk', '=', 'matakuliah.kode_mk')
        ->where('irs.nim', $nim)
        ->selectRaw('
            SUM(matakuliah.sks * 
                CASE
                    WHEN irs.nilai >= 85.00 THEN 4.00
                    WHEN irs.nilai >= 80.00 AND irs.nilai < 85.00 THEN 3.50
                    WHEN irs.nilai >= 75.00 AND irs.nilai < 80.00 THEN 3.00
                    WHEN irs.nilai >= 70.00 AND irs.nilai < 75.00 THEN 2.50
                    WHEN irs.nilai >= 60.00 AND irs.nilai < 70.00 THEN 2.00
                    WHEN irs.nilai >= 40.00 AND irs.nilai < 60.00 THEN 1.00
                    ELSE 0.00
                END
            ) / SUM(matakuliah.sks) AS ipk
        ')
        ->value('ipk') ?? 0;

        $sksk = irs::where('nim', $nim)
            ->join('jadwal', 'irs.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('matakuliah', 'matakuliah.kode_mk', '=', 'jadwal.kode_mk')
            ->sum('matakuliah.sks') ?? 0;

        $riwayat_status = RiwayatStatus::where('nim', $nim)
            -> join('tahun_ajaran', 'riwayat_status.id_tahun', '=', 'tahun_ajaran.id_tahun')
            -> orderBy('tahun_ajaran.id_tahun', 'asc')
            -> get() ?? die('No Data');

        // Kirim data ke view
        return view('mhs/dashboard-mhs', compact('mhs', 'doswal', 'tahun_ajaran', 'ipk', 'sksk', 'riwayat_status'));
    }

    public function irs()
    {
        $nim = session('nim');

        // Ambil data mahasiswa  dari database
        $mhs = Mahasiswa::where('nim', $nim)
            ->join('dosen', 'dosen.nidn', '=', 'mahasiswa.nidn')
            ->join('prodi', 'prodi.id_prodi', '=', 'dosen.id_prodi')
            ->join('fakultas', 'fakultas.id_fakultas', '=', 'prodi.id_fakultas')
            ->select('mahasiswa.nim', 'mahasiswa.nama', 'dosen.nidn', 'dosen.nama as nama_dosen', 'prodi.nama_prodi', 'prodi.strata', 'fakultas.nama_fakultas')
            ->first() ?? 'Unknown';

        if ($mhs) {
            $mhs->nama = ucwords(strtolower($mhs->nama));
            $mhs->nama_fakultas = strtoupper($mhs->nama_fakultas);
        }

        $tahun_ajaran = RiwayatStatus::where('nim',$nim)
            -> join('tahun_ajaran', 'riwayat_status.id_tahun', '=', 'tahun_ajaran.id_tahun')
            -> orderBy('tahun_ajaran.id_tahun', 'asc')
            -> get() ?? die('No Data');

        // Hitung semester secara dinamis dan hilangkan data dengan status "Cuti"
        $semester = 1; // Semester awal
        $filtered_tahun_ajaran = [];

        foreach ($tahun_ajaran as $ta) {
            if ($ta->status === 'AKTIF') {
                $filtered_tahun_ajaran[] = [
                    'semester' => $semester,
                    'id_tahun' => $ta->id_tahun,
                    'tahun_ajaran' => $ta->tahun_ajaran,
                ];
            }
            $semester++;
        }

        // Kirim data ke view
        return view('mhs/irs-mhs', compact('mhs', 'filtered_tahun_ajaran'));        
    }

    public function pengisianIrs()
    {
        $nim = session('nim');

        // Ambil data mahasiswa  dari database
        $mhs = Mahasiswa::where('nim', $nim)->first() ?? 'Unknown';
            
        if ($mhs) {
            $mhs->nama = ucwords(strtolower($mhs->nama));
        }

        $tahun_ajaran = RiwayatStatus::where('nim',$nim)
            -> join('tahun_ajaran', 'riwayat_status.id_tahun', '=', 'tahun_ajaran.id_tahun')
            -> orderBy('tahun_ajaran.id_tahun', 'desc')
            -> get();

        $ta_skrg = $tahun_ajaran->first() ?? 'Unknown';
        $status_lalu = $tahun_ajaran->skip(1)->first()->status ?? 'Unknown';

        $ips = irs::where('nim', $nim)
            ->join('jadwal', 'jadwal.id_jadwal', '=', 'irs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kode_mk', '=', 'jadwal.kode_mk')
            ->groupBy('jadwal.id_tahun')
            ->select(
                'jadwal.id_tahun', // Menyertakan id_tahun dalam hasil seleksi
                DB::raw("
                    SUM(
                        CASE 
                            WHEN irs.nilai >= 85.00 THEN 4.00
                            WHEN irs.nilai >= 80.00 AND irs.nilai < 85.00 THEN 3.50
                            WHEN irs.nilai >= 75.00 AND irs.nilai < 80.00 THEN 3.00
                            WHEN irs.nilai >= 70.00 AND irs.nilai < 75.00 THEN 2.50
                            WHEN irs.nilai >= 60.00 AND irs.nilai < 70.00 THEN 2.00
                            WHEN irs.nilai >= 40.00 AND irs.nilai < 60.00 THEN 1.00
                            ELSE 0.00
                        END * matakuliah.sks
                    ) AS total_bobot, 
                    SUM(matakuliah.sks) AS total_sks
                ")
            )
            ->orderBy('jadwal.id_tahun', 'desc')
            ->first();

        $ipslalu = $ips->total_bobot / $ips->total_sks ?? 0;

        // Menentukan batas SKS
        $maxsks = 20; // Default batas SKS

        if ($mhs->semester == 1 || $mhs->semester == 2) {
            // Semester pertama dan kedua
            if ($ipslalu < 2.00) {
                $maxsks = 18; // Semester kedua jika IPS < 2.00
            }
        } else {
            // Semester ketiga dan seterusnya
            if ($status_lalu != 'AKTIF') {
                $maxsks = 18; // Jika status mangkir, cuti atau skorsing
            } else {
                // Berdasarkan IPS semester lalu
                if ($ipslalu < 2.00) {
                    $maxsks = 18;
                } elseif ($ipslalu >= 2.00 && $ipslalu < 2.50) {
                    $maxsks = 20;
                } elseif ($ipslalu >= 2.50 && $ipslalu < 3.00) {
                    $maxsks = 22;
                } else {
                    $maxsks = 24;
                }
            }
        }

        $listmk = Jadwal::join('usulanjadwal', function($join) use ($ta_skrg) {
                $join->on('jadwal.id_prodi', '=', 'usulanjadwal.id_prodi')
                    ->on('jadwal.id_tahun', '=', 'usulanjadwal.id_tahun')
                    ->where('usulanjadwal.status', 'Disetujui');
            })
            ->where('jadwal.id_tahun', $ta_skrg->id_tahun)
            ->join('matakuliah', 'matakuliah.kode_mk', '=', 'jadwal.kode_mk')
            ->select('matakuliah.nama_mk', 'matakuliah.kode_mk', 'matakuliah.sks')
            ->distinct('matakuliah.kode_mk')
            ->get()
            ->keyBy('kode_mk');
    

        $jadwalmk = Jadwal::join('usulanjadwal', function($join) use ($ta_skrg) {
                $join->on('jadwal.id_prodi', '=', 'usulanjadwal.id_prodi')
                     ->on('jadwal.id_tahun', '=', 'usulanjadwal.id_tahun')
                     ->where('usulanjadwal.status', 'Disetujui');
            })
            ->where('jadwal.id_tahun', $ta_skrg->id_tahun)
            ->join('matakuliah', 'matakuliah.kode_mk', '=', 'jadwal.kode_mk')
            ->select(
                'jadwal.id_jadwal',
                'jadwal.kelas',
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
                'jadwal.kuota',
                DB::raw("
                    CASE jadwal.id_ruang
                        WHEN '0000' THEN 'Lapangan Stadion UNDIP'
                        ELSE jadwal.id_ruang
                    END AS id_ruang
                "),
                'matakuliah.kode_mk',
                'matakuliah.nama_mk',
                'matakuliah.plot_semester as p_smt',
                'matakuliah.sks',
                'matakuliah.jenis'
            )
            ->orderBy('jadwal.id_jadwal')
            ->get()
            ->keyBy('id_jadwal');
        

        // Kirim data ke view
        return view('mhs/pengisianirs-mhs', compact('mhs', 'ta_skrg', 'status_lalu', 'ipslalu', 'maxsks', 'listmk', 'jadwalmk'));        
    }
}
