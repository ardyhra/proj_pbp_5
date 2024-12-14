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
         // Ambil semua tahun ajaran dengan usulan yang statusnya "diajukan"
        $tahunAjaranList = TahunAjaran::whereHas('usulanRuangKuliah', function ($query) {
        })->get();

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
    // public function updateStatusUsulanDekan(Request $request, $id_tahun)
    // {
    //     $validated = $request->validate([
    //         'status' => 'required|in:disetujui,ditolak,batalkan',
    //     ]);

    //     if ($validated['status'] === 'batalkan') {
    //         // Kembalikan status ke 'diajukan'
    //         $newStatus = 'diajukan';
    //     } else {
    //         $newStatus = $validated['status'];
    //     }

    //     UsulanRuangKuliah::where('id_tahun', $id_tahun)
    //         ->update(['status' => $newStatus]);

    //     return response()->json(['message' => 'Status usulan berhasil diperbarui oleh Dekan.']);
    // }
    public function updateStatusUsulanDekan(Request $request, $id_tahun, $id_prodi)
    {
        // Log atau Debug
        Log::info("ID Tahun: $id_tahun, ID Prodi: $id_prodi");
    
        // Validasi status yang diterima
        $validated = $request->validate([
            'status' => 'required|in:belum diajukan,diajukan,disetujui,ditolak',
        ]);
    
        // Mencari usulan ruang kuliah untuk tahun ajaran dan program studi yang dipilih
        $usulan = UsulanRuangKuliah::where('id_tahun', $id_tahun)
                                   ->where('id_prodi', $id_prodi)
                                   ->first(); 
    
        // Jika usulan ditemukan, update statusnya
        if ($usulan) {
            Log::info("Usulan ditemukan, status sebelum update: " . $usulan->status);
    
            $usulan->status = $validated['status']; 
            $usulan->save(); 
    
            return response()->json(['message' => 'Status usulan prodi berhasil diperbarui oleh Dekan.']);
        }
    
        // Jika usulan tidak ditemukan
        Log::error("Usulan tidak ditemukan untuk ID Tahun: $id_tahun dan ID Prodi: $id_prodi");
        return response()->json(['message' => 'Usulan tidak ditemukan.'], 404);
    }
    


    // public function updateStatusUsulanProdiDekan(Request $request, $id_tahun, $id_prodi)
    // {
    //     $validated = $request->validate([
    //         'status' => 'required|in:belum diajukan,diajukan,disetujui,ditolak,batalkan',
    //     ]);

    //     $newStatus = $validated['status'];
    //     if ($newStatus === 'batalkan') {
    //         $newStatus = 'diajukan';
    //     }

    //     UsulanRuangKuliah::where('id_tahun', $id_tahun)
    //         ->where('id_prodi', $id_prodi)
    //         ->update(['status' => $newStatus]);

    //     return response()->json(['message' => 'Status usulan prodi berhasil diperbarui oleh Dekan.']);
    // }

    public function updateStatusUsulanProdiDekan(Request $request, $id_tahun, $id_prodi)
    {
        // Validasi status yang diterima
        $validated = $request->validate([
            'status' => 'required|in:belum diajukan,diajukan,disetujui,ditolak',
        ]);
    
        // Update status usulan ruang kuliah untuk tahun dan prodi yang dipilih
        $usulan = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->first();
    
        if ($usulan) {
            $usulan->status = $validated['status'];
            $usulan->save();
    
            return response()->json(['message' => 'Status usulan prodi berhasil diperbarui oleh Dekan.']);
        }
    
        return response()->json(['message' => 'Usulan tidak ditemukan.'], 404);
    }
    

    // Mendapatkan data usulan berdasarkan tahun ajaran
    public function getUsulan($id_tahun)
    {
        $data = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->with('programStudi:id_prodi,nama_prodi')
            ->get()
            ->groupBy('id_prodi')
            ->map(function($items, $id_prodi) {
                return [
                    'id_prodi' => $id_prodi,
                    'program_studi' => $items->first()->programStudi->nama_prodi,
                    'jumlah_ruang' => $items->count(),
                    'status' => $items->first()->status ?? 'belum diajukan'
                ];
            })
            ->values();

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
            'status' => $usulanList->first()->status ?? 'belum diajukan',
        ];

        return response()->json($data);
    }

}
