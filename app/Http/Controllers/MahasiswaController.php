<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\RiwayatStatus;
use App\Models\irs;
use App\Models\Jadwal; 
use Illuminate\Http\Request;

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

        // Kirim data ke view
        return view('mhs/pengisianirs-mhs', compact('mhs'));        
    }
}
