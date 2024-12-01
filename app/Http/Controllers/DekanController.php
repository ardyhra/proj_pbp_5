<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\UsulanRuangKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DekanController extends Controller
{
    // Metode untuk Dekan
    public function indexDekan()
    {
        $tahunAjaranList = TahunAjaran::all();

        $usulanStatuses = UsulanRuangKuliah::select('id_tahun', 'status')
            ->distinct()
            ->get()
            ->groupBy('id_tahun');

        return view('dekan.usulanruang', compact('tahunAjaranList', 'usulanStatuses'));
    }

    // Mengupdate status usulan oleh Dekan
    public function updateStatusUsulanDekan(Request $request, $id_tahun)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        // Update semua usulan untuk tahun ajaran tertentu
        UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status usulan berhasil diperbarui oleh Dekan.']);
    }

    // Endpoint untuk mendapatkan data usulan
    public function getUsulan($id_tahun)
    {
        $data = UsulanRuangKuliah::select('id_prodi', DB::raw('COUNT(id_ruang) as jumlah_ruang'))
            ->where('id_tahun', $id_tahun)
            ->groupBy('id_prodi')
            ->with('programStudi:id_prodi,nama_prodi')
            ->get()
            ->map(function($item) {
                return [
                    'id_prodi' => $item->id_prodi,
                    'program_studi' => $item->programStudi->nama_prodi,
                    'jumlah_ruang' => $item->jumlah_ruang,
                ];
            });

        return response()->json($data);
    }

    // Endpoint untuk mendapatkan detail usulan
    public function getUsulanDetail($id_tahun, $id_prodi)
    {
        $usulan = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->with('programStudi:id_prodi,nama_prodi', 'ruang:id_ruang,kapasitas')
            ->get();

        $data = [
            'program_studi' => $usulan->first()->programStudi->nama_prodi ?? '',
            'ruang' => $usulan->map(function($item) {
                return [
                    'id_ruang' => $item->ruang->id_ruang,
                    'kapasitas' => $item->ruang->kapasitas,
                ];
            })->toArray(),
        ];

        return response()->json($data);
    }
}
