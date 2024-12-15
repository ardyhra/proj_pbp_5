<?php
namespace App\Http\Controllers;
use App\Models\UsulanJadwal;
use App\Models\tahunajaran;
use App\Models\Jadwal;
use App\Models\ProgramStudi;
use App\Models\matakuliah;
use Illuminate\Http\Request;


class UsulanjadwalController extends Controller
{
    public function ajukan(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun_ajaran,id_tahun',
            'id_prodi' => 'required|exists:prodi,id_prodi',
        ]);

        $jadwalAda = Jadwal::where('id_tahun', $request->id_tahun)
            ->where('id_prodi', $request->id_prodi)
            ->exists();

        if (!$jadwalAda) {
            return redirect()->back()->with('error', 'Tidak dapat mengajukan jadwal karena jadwal masih kosong.');
        }

        $usulan = UsulanJadwal::where('id_tahun', $request->id_tahun)
            ->where('id_prodi', $request->id_prodi)
            ->first();

        if ($usulan) {
            // Cek status usulan saat ini
            if (in_array($usulan->status, ['Diajukan', 'Disetujui'])) {
                // Jika sudah diajukan atau disetujui, tidak bisa diajukan lagi
                return redirect()->back()->with('error', 'Usulan jadwal sudah diajukan atau sudah disetujui.');
            } else {
                // Status 'Belum Diajukan' atau 'Ditolak', bisa diajukan kembali
                $usulan->status = 'Diajukan';
                $usulan->save();
                return redirect()->back()->with('success', 'Usulan jadwal berhasil diajukan kembali.');
            }
        } else {
            // Belum pernah ada usulan, maka buat usulan baru dengan status 'Diajukan'
            UsulanJadwal::create([
                'id_tahun' => $request->id_tahun,
                'id_prodi' => $request->id_prodi,
                'status' => 'Diajukan',
            ]);

            return redirect()->back()->with('success', 'Usulan jadwal berhasil diajukan.');
        }
    }

    public function batalkanUsulan(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun_ajaran,id_tahun',
            'id_prodi' => 'required|exists:prodi,id_prodi',
        ]);

        $usulan = UsulanJadwal::where('id_tahun', $request->id_tahun)
            ->where('id_prodi', $request->id_prodi)
            ->first();

        if ($usulan && $usulan->status == 'Diajukan') {
            $usulan->status = 'Belum Diajukan';
            $usulan->save();
            return redirect()->back()->with('success', 'Usulan jadwal berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Usulan tidak dalam status diajukan atau tidak ditemukan.');
    }



    public function index()
    {
        // Ambil id_tahun yang memiliki usulan jadwal
        $tahunIds = UsulanJadwal::distinct()->pluck('id_tahun');

        // Ambil hanya tahun ajaran yang ada usulannya
        $tahunajarans = TahunAjaran::whereIn('id_tahun', $tahunIds)->get();

        // Ambil semua usulan jadwal yang terkait dengan tahun-tahun tersebut
        $usulanJadwals = UsulanJadwal::with('tahunAjaran', 'prodi')
                        ->whereIn('id_tahun', $tahunIds)
                        ->get();

        return view('dekan.usulanjadwal', compact('tahunajarans', 'usulanJadwals'));
    }


    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Diajukan,Disetujui,Ditolak',
        ]);

        $usulan = UsulanJadwal::findOrFail($id);
        $usulan->status = $validated['status'];
        $usulan->save();

        return response()->json(['message' => 'Status usulan berhasil diperbarui.']);
    }


    public function rekapJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan prodi untuk form
        $tahunajarans = TahunAjaran::all();
        $prodis = ProgramStudi::all();

        // Mengambil id_tahun dan id_prodi dari request
        $id_tahun = $request->id_tahun;
        $id_prodi = $request->id_prodi;

        // Ambil data usulan jadwal berdasarkan tahun ajaran dan prodi yang dipilih
        $usulanJadwals = UsulanJadwal::where('id_tahun', $id_tahun)
                                    ->where('id_prodi', $id_prodi)
                                    ->get();

        // Kirim data ke view
        return view('kaprodi.rekapjadwal', compact('tahunajarans', 'prodis', 'usulanJadwals', 'id_tahun', 'id_prodi'));
    }

    public function detailJadwal(Request $request)
    {
        // Ambil data tahun ajaran dan prodi untuk form
        $tahunajarans = TahunAjaran::all();
        $prodis = ProgramStudi::all();

        // Ambil data usulan jadwal dengan tahun ajaran dan nama prodi
        $usulanJadwals = UsulanJadwal::join('tahun_ajaran', 'usulanjadwal.id_tahun', '=', 'tahun_ajaran.id_tahun')
                                    ->join('prodi', 'usulanjadwal.id_prodi', '=', 'prodi.id_prodi')
                                    ->select('usulanjadwal.id_tahun', 'usulanjadwal.id_prodi', 'tahun_ajaran.tahun_ajaran', 'prodi.nama_prodi', 'usulanjadwal.status')
                                    ->orderBy('id_tahun')
                                    ->get();

        // Kirim data ke view
        return view('kaprodi.rekapjadwal', compact('tahunajarans', 'prodis', 'usulanJadwals'));
    }


    // Sisi Dekan
    public function getUsulanJadwalByTahun($id_tahun)
    {
        // Ambil semua usulan jadwal untuk tahun ajaran ini
        $usulanJadwals = UsulanJadwal::with('prodi')
            ->where('id_tahun', $id_tahun)
            ->get();

        // Map data agar mudah dibaca oleh frontend
        $data = $usulanJadwals->map(function($item) {
            return [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => ($item->prodi->strata ?? '').' - '.$item->prodi->nama_prodi,
                'status' => $item->status,
            ];
        });

        return response()->json($data);
    }

    // Detail untuk per prodi (jika diperlukan)
    // Misalnya detail ini menampilkan jadwal kuliah yang sudah diusulkan oleh prodi tersebut.
    public function getUsulanJadwalDetail($id_tahun, $id_prodi)
    {
        // Ambil semua jadwal dari tabel jadwal untuk prodi dan tahun ini (tanpa with('matakuliah'))
        $jadwals = Jadwal::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->get();

        // Ambil semua kode_mk yang ada di jadwal tersebut
        $kodeMkList = $jadwals->pluck('kode_mk')->unique();

        // Ambil data matakuliah dari tabel matakuliah untuk semua kode_mk yang ditemukan
        $mkData = matakuliah::whereIn('kode_mk', $kodeMkList)
            ->pluck('nama_mk', 'kode_mk');

        // Ambil prodi
        $prodi = ProgramStudi::find($id_prodi);

        // Ambil status usulan jadwal
        $status = UsulanJadwal::where('id_tahun', $id_tahun)
                    ->where('id_prodi', $id_prodi)
                    ->value('status') ?? 'Belum Diajukan';

        $data = [
            'program_studi' => $prodi->nama_prodi,
            'jadwal' => $jadwals->map(function($j) use ($mkData) {
                return [
                    'kode_mk' => $j->kode_mk,
                    'nama_mk' => $mkData[$j->kode_mk] ?? '', // Ambil nama_mk dari array $mkData
                    'hari' => $this->formatHari($j->hari),
                    'waktu' => $j->waktu_mulai.' - '.$j->waktu_selesai,
                    'ruang' => $j->id_ruang,
                    'kelas' => $j->kelas
                ];
            }),
            'status' => $status,
        ];

        return response()->json($data);
    }



    private function formatHari($hariNum)
    {
        $hariMap = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        return $hariMap[$hariNum] ?? 'Tidak Diketahui';
    }

    // Update status usulan jadwal pada level prodi (mirip dengan usulan ruang)
    public function updateStatusUsulanProdiDekan(Request $request, $id_tahun, $id_prodi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Belum Diajukan,Diajukan,Disetujui,Ditolak'
        ]);

        $usulan = UsulanJadwal::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->firstOrFail();

        $usulan->status = $validated['status'];
        $usulan->save();

        return response()->json(['message' => 'Status usulan jadwal berhasil diperbarui.']);
    }

    
}

