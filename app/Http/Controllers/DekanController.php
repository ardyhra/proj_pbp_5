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

        // Mendapatkan status usulan per tahun
        $usulanStatuses = UsulanRuangKuliah::select('id_tahun', 'status')
            ->distinct()
            ->get()
            ->groupBy('id_tahun');

        // Mapping status untuk setiap tahun ajaran
        $rekapStatuses = $tahunAjaranList->mapWithKeys(function($tahun) use ($usulanStatuses) {
            $usulanStatus = $usulanStatuses->get($tahun->id_tahun);
            if ($usulanStatus && $usulanStatus->isNotEmpty()) {
                $status = $usulanStatus->first()->status;
            } else {
                $status = 'belum diajukan';
            }
            return [$tahun->id_tahun => $status];
        });

        return view('dekan.usulanruang', [
            'tahunAjaranList' => $tahunAjaranList,
            'usulanStatuses' => $rekapStatuses
        ]);
    }


    // Mengupdate status usulan oleh Dekan
    public function updateStatusUsulanDekan(Request $request, $id_tahun)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,batalkan',
        ]);

        if ($validated['status'] === 'batalkan') {
            // Kembalikan status ke 'diajukan'
            $newStatus = 'diajukan';
        } else {
            $newStatus = $validated['status'];
        }

        UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->update(['status' => $newStatus]);

        return response()->json(['message' => 'Status usulan berhasil diperbarui oleh Dekan.']);
    }


    // Mendapatkan data usulan berdasarkan tahun ajaran
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

    // Mendapatkan detail usulan berdasarkan tahun ajaran dan program studi
    public function getUsulanDetail($id_tahun, $id_prodi)
    {
        $usulanList = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->with('ruang', 'programStudi')
            ->get();

        $data = [
            'program_studi' => $usulanList->first()->programStudi->nama_prodi ?? '',
            'ruang' => $usulanList->map(function ($usulan) {
                return [
                    'id_ruang' => $usulan->id_ruang,
                    'kapasitas' => $usulan->ruang->kapasitas ?? ''
                ];
            })->toArray(),
        ];

        return response()->json($data);
    }
}
