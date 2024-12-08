<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Ruang;
use App\Models\tahunajaran;
use App\Models\UsulanRuangKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class UsulanController extends Controller
{

    public function index()
    {
        $tahunAjaranList = TahunAjaran::all();
    
        // Dapatkan tahun ajaran yang punya usulan
        $usulanPerTahun = UsulanRuangKuliah::select('id_tahun')
            ->distinct()
            ->get();
    
        // Filter tahun ajaran agar hanya memuat tahun yang ada usulannya
        $tahunAjaranList = $tahunAjaranList->whereIn('id_tahun', $usulanPerTahun->pluck('id_tahun'));
    
        // Ambil semua data usulan dengan relasi
        $usulanList = UsulanRuangKuliah::with('programStudi', 'tahunAjaran')->get();
    
        // Ambil status usulan per tahun ajaran (jika masih diperlukan)
        // Namun sekarang status di level tahun ajaran tidak lagi ditampilkan, 
        // jadi kita bisa abaikan atau hapus pemakaian $usulanStatuses
        // $usulanStatuses = ... // bisa dihapus jika tidak dipakai
    
        return view('ba.daftarusulan', compact('tahunAjaranList', 'usulanList'));
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
            return response()->json(['message' => 'Data atau tahun ajaran tidak boleh kosong.'], 400);
        }

        // Check if the usulan for the selected tahun ajaran has status 'disetujui'
        $existingUsulan = UsulanRuangKuliah::where('id_tahun', $id_tahun)->first();
        if ($existingUsulan && $existingUsulan->status == 'disetujui') {
            return response()->json(['message' => 'Usulan telah disetujui dan tidak dapat diubah.'], 400);
        }

        // Validasi ruang overlap
        foreach ($data as $id_prodi => $prodiData) {
            $ruangList = $prodiData['ruang'] ?? [];
            $overlap = UsulanRuangKuliah::where('id_tahun', $id_tahun)
                ->whereIn('id_ruang', $ruangList)
                ->where('id_prodi', '!=', $id_prodi)
                ->exists();

            if ($overlap) {
                return response()->json(['message' => 'Beberapa ruang sudah digunakan oleh program studi lain.'], 400);
            }
        }

        // Delete existing usulan for the selected academic year
        UsulanRuangKuliah::where('id_tahun', $id_tahun)->delete();

        // Save new usulan data
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

    public function getUsulanData($id_tahun)
    {
        $usulanList = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->with('programStudi')
            ->get();

        if ($usulanList->isEmpty()) {
            return response()->json([
                'usulanData' => [],
            ]);
        }

        $usulanData = [];
        // Kelompokkan per prodi
        $grouped = $usulanList->groupBy('id_prodi');
        foreach ($grouped as $id_prodi => $items) {
            $nama_prodi = $items->first()->programStudi->nama_prodi;
            $ruang = $items->pluck('id_ruang')->toArray();
            $status = $items->first()->status ?? 'belum diajukan';

            $usulanData[$id_prodi] = [
                'nama_prodi' => $nama_prodi,
                'ruang' => $ruang,
                'status' => $status,
            ];
        }

        return response()->json([
            'usulanData' => $usulanData,
        ]);
    }

    public function storeProdi(Request $request)
    {
        $validated = $request->validate([
            'id_tahun' => 'required',
            'id_prodi' => 'required',
            'ruang' => 'array'
        ]);

        $id_tahun = $validated['id_tahun'];
        $id_prodi = $validated['id_prodi'];
        $ruangList = $validated['ruang'] ?? [];

        // Cek status prodi, jika disetujui, tolak perubahan
        $existingUsulan = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->first();

        if ($existingUsulan && $existingUsulan->status == 'disetujui') {
            return response()->json(['message' => 'Usulan prodi ini telah disetujui dan tidak dapat diubah.'], 400);
        }

        // Hapus usulan sebelumnya untuk prodi ini
        UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->delete();

        // Simpan data baru
        foreach ($ruangList as $id_ruang) {
            UsulanRuangKuliah::create([
                'id_prodi' => $id_prodi,
                'id_ruang' => $id_ruang,
                'id_tahun' => $id_tahun,
            ]);
        }

        return response()->json(['message' => 'Usulan prodi berhasil disimpan.']);
    }




    public function getUsulanByTahun($id_tahun)
    {
        $usulanData = UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->with('programStudi')
            ->get()
            ->groupBy('id_prodi')
            ->map(function ($items, $id_prodi) {
                $jumlah_ruang = $items->count();
                $program_studi = $items->first()->programStudi->nama_prodi;
                $status = $items->first()->status ?? 'belum diajukan'; // Pastikan ambil status disini
                return [
                    'id_prodi' => $id_prodi,
                    'program_studi' => $program_studi,
                    'jumlah_ruang' => $jumlah_ruang,
                    'status' => $status // Tambahkan status disini
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
            }),
            'status' => $usulanList->first()->status ?? 'belum diajukan', // Tambahkan ini
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

    public function updateStatusUsulanProdi(Request $request, $id_tahun, $id_prodi)
    {
        $validated = $request->validate([
            'status' => 'required|in:belum diajukan,diajukan,disetujui,ditolak',
        ]);

        UsulanRuangKuliah::where('id_tahun', $id_tahun)
            ->where('id_prodi', $id_prodi)
            ->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status usulan prodi berhasil diperbarui.']);
    }




}
