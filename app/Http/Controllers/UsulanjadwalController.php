<?php
namespace App\Http\Controllers;
use App\Models\UsulanJadwal;
use App\Models\tahunajaran;
use App\Models\Jadwal;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;


class UsulanJadwalController extends Controller
{
    public function ajukan(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_tahun' => 'required|exists:tahun_ajaran,id_tahun',
            'id_prodi' => 'required|exists:prodi,id_prodi',
        ]);
    
        // Cek apakah jadwal untuk tahun ajaran dan prodi yang dipilih sudah ada
        $jadwalAda = Jadwal::where('id_tahun', $request->id_tahun)
            ->where('id_prodi', $request->id_prodi)
            ->exists();
    
        if (!$jadwalAda) {
            return redirect()->back()->with('error', 'Tidak dapat mengajukan jadwal karena jadwal masih kosong.');
        }
    
        // Cek apakah usulan sudah ada
        $usulan = UsulanJadwal::where('id_tahun', $request->id_tahun)
            ->where('id_prodi', $request->id_prodi)
            ->first();
    
        if ($usulan) {
            return redirect()->back()->with('error', 'Usulan jadwal sudah diajukan.');
        }
    
        // Buat usulan baru
        UsulanJadwal::create([
            'id_tahun' => $request->id_tahun,
            'id_prodi' => $request->id_prodi,
            'status' => 'Diajukan',
        ]);
    
        return redirect()->back()->with('success', 'Usulan jadwal berhasil diajukan.');
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
}

