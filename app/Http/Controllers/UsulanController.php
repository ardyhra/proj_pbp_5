<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Ruang;
use App\Models\tahunajaran;
use App\Models\UsulanRuangKuliah;
use Illuminate\Http\Request;

class UsulanController extends Controller
{

    public function index()
    {
        $tahunAjaranList = TahunAjaran::all();

        // Get list of academic years that have usulan
        $usulanPerTahun = UsulanRuangKuliah::select('id_tahun')
            ->distinct()
            ->with('tahunAjaran')
            ->get();

        // Ambil semua data usulan dengan relasi
        $usulanList = UsulanRuangKuliah::with('programStudi', 'tahunAjaran')->get();

        $usulanStatuses = UsulanRuangKuliah::select('id_tahun', 'status')
        ->distinct()
        ->get()
        ->groupBy('id_tahun');

        // Kirim semua data ke view
        return view('ba.daftarusulan', compact('tahunAjaranList', 'usulanPerTahun', 'usulanList', 'usulanStatuses'));
    }


    public function create()
    {
        $programStudiList = ProgramStudi::all();
        $ruangList = Ruang::all();
        $tahunAjaranList = TahunAjaran::all();

        // Initialize usulanData
        $usulanData = [];

        $usulanList = UsulanRuangKuliah::all();

        // Process usulan data to send to frontend
        foreach ($usulanList as $usulan) {
            $id_prodi = $usulan->id_prodi;
            $id_ruang = $usulan->id_ruang;
            $id_tahun = $usulan->id_tahun;

            if (!isset($usulanData[$id_tahun])) {
                $usulanData[$id_tahun] = [];
            }

            if (!isset($usulanData[$id_tahun][$id_prodi])) {
                $usulanData[$id_tahun][$id_prodi] = [
                    'nama_prodi' => $usulan->programStudi->nama_prodi,
                    'ruang' => []
                ];
            }

            $usulanData[$id_tahun][$id_prodi]['ruang'][] = $id_ruang;
        }

        return view('ba.buatusulan', compact('programStudiList', 'ruangList', 'tahunAjaranList', 'usulanData'));
    }

    public function store(Request $request)
    {
        $data = $request->input('data'); // Data from programStudiRuang
        $id_tahun = $request->input('id_tahun'); // Get the selected academic year
    
        // Validate data
        if (empty($data) || empty($id_tahun)) {
            return response()->json(['message' => 'Data or academic year is missing'], 400);
        }
    
        // Delete existing usulan for the selected academic year
        UsulanRuangKuliah::where('id_tahun', $id_tahun)->delete();
    
        foreach ($data as $id_prodi => $prodiData) {
            $ruangList = $prodiData['ruang'] ?? [];
            foreach ($ruangList as $id_ruang) {
                UsulanRuangKuliah::create([
                    'id_prodi' => $id_prodi,
                    'id_ruang' => $id_ruang,
                    'id_tahun' => $id_tahun,
                ]);
            }
        }
    
        return response()->json(['message' => 'Usulan berhasil disimpan'], 200);
    }
    

    public function getProgramStudi(Request $request)
    {
        $search = $request->input('q'); // Input pencarian dari Select2

        // Ambil data program studi berdasarkan pencarian
        $programStudi = ProgramStudi::where('nama_prodi', 'like', "%$search%")
            ->select('id_prodi', 'nama_prodi')
            ->get();

        // Return sebagai JSON
        return response()->json($programStudi);
    }

    public function getUsulanByTahun($id_tahun)
    {
        $usulanData = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->with('programStudi')
            ->get()
            ->groupBy('id_prodi')
            ->map(function ($items, $id_prodi) {
                return [
                    'id_prodi' => $id_prodi,
                    'program_studi' => $items->first()->programStudi->nama_prodi,
                    'jumlah_ruang' => $items->count()
                ];
            })
            ->values();

        return response()->json($usulanData);
    }

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
            })
        ];

        return response()->json($data);
    }

    public function updateStatusUsulan(Request $request, $id_tahun)
    {
        $validated = $request->validate([
            'status' => 'required|in:belum diajukan,diajukan',
        ]);

        UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status usulan berhasil diperbarui.']);
    }


}
