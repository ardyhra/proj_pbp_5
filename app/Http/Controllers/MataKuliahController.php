<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Database\Seeders\MatakuliahSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
class MataKuliahController extends Controller
{
    // Menampilkan daftar mata kuliah
    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return view('matkul.index', compact('mataKuliah'));
    }

    // Menampilkan form tambah mata kuliah
    public function create()
    {
        return view('matkul.create');
    }

    // Menyimpan data mata kuliah
    public function store(Request $request)
    {
        $request->validate([
            // Kode MK harus unik, tipe string, maksimal 10 karakter
            'kode_mk' => 'required|string|max:10',
            
            // Nama MK harus unik, tipe string, maksimal 255 karakter
            'nama_mk' => 'required|string|max:255',
            
            // SKS harus berupa angka, range 1-6
            'sks' => 'required|integer|between:1,6',
            
            // Semester harus berupa angka, range 1-8
            'plot_semester' => 'required|integer|between:1,8',
            
            // Jenis harus bernilai "W" (Wajib) atau "P" (Pilihan)
            'jenis' => 'required|string|in:W,P',
        ], [
            // Pesan error custom untuk setiap aturan
            'kode_mk.required' => 'Kode Mata Kuliah wajib diisi.',
            'kode_mk.string' => 'Kode Mata Kuliah harus berupa teks.',
            'kode_mk.max' => 'Kode Mata Kuliah maksimal 10 karakter.',
            'kode_mk.unique' => 'Kode Mata Kuliah sudah digunakan, gunakan kode lain.',
            
            'nama_mk.required' => 'Nama Mata Kuliah wajib diisi.',
            'nama_mk.string' => 'Nama Mata Kuliah harus berupa teks.',
            'nama_mk.max' => 'Nama Mata Kuliah maksimal 255 karakter.',
            'nama_mk.unique' => 'Nama Mata Kuliah sudah digunakan, gunakan nama lain.',
            
            'sks.required' => 'SKS wajib diisi.',
            'sks.integer' => 'SKS harus berupa angka.',
            'sks.between' => 'SKS harus berada dalam range 1 sampai 6.',
            
            'plot_semester.required' => 'Semester wajib diisi.',
            'plot_semester.integer' => 'Semester harus berupa angka.',
            'plot_semester.between' => 'Semester harus berada dalam range 1 sampai 8.',
            
            'jenis.required' => 'Jenis Mata Kuliah wajib dipilih.',
            'jenis.string' => 'Jenis Mata Kuliah harus berupa teks.',
            'jenis.in' => 'Jenis Mata Kuliah hanya dapat berupa "W" (Wajib) atau "P" (Pilihan).',
        ]);
    
        // Simpan data ke tabel
        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'plot_semester' => $request->plot_semester,
            'jenis' => $request->jenis,
        ]);
    
        return redirect()->route('manajemen-matkul-kaprodi')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }
    

    public function checkUnique(Request $request)
    {
        $kodeMkExists = Matakuliah::where('kode_mk', $request->kode_mk)->exists();
        $namaMkExists = MataKuliah::where('nama_mk', $request->nama_mk)->exists();

        if ($kodeMkExists) {
            return response()->json(['exists' => true, 'message' => 'Kode Mata Kuliah sudah digunakan.']);
        }

        if ($namaMkExists) {
            return response()->json(['exists' => true, 'message' => 'Nama Mata Kuliah sudah digunakan.']);
        }

        return response()->json(['exists' => false]);
    }

    // public function edit($kode_mk)
    // {   
    //     $kode = $kode_mk;
    //      // Ambil data mata kuliah berdasarkan kode_mk
    //     //atkul = MataKuliah::where('kode_mk', $kode_mk)->firstorfail();
    //     $matkul = MataKuliah::find($kode_mk);
    //     if (!$matkul) {
    //         return redirect()->back()->withErrors('Mata kuliah tidak ditemukan.');
    //     }
    //     $matakuliah = MataKuliah::all();
        
    //     return view('matkul.edit', compact('matkul','kode','matakuliah'));
    // }

    public function edit($kode_mk)
    {
        $matkul = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        return view('matkul.edit', compact('matkul'));
    }
    
    // public function update(Request $request, $kode_mk)
    // {
    //     dd($kode_mk);
    //     $request->validate([
    //         'kode_mk' => 'required|string|max:10|unique:matkul,kode_mk,' . $kode_mk . ',kode_mk',
    //         'nama_mk' => 'required|string|max:255|unique:matkul,nama_mk,' . $kode_mk . ',kode_mk',
    //         'sks' => 'required|integer|between:1,6',
    //         'plot_semester' => 'required|integer|between:1,8',
    //         'jenis' => 'required|string|in:W,P',
    //     ], [
    //         'kode_mk.required' => 'Kode Mata Kuliah wajib diisi.',
    //         'kode_mk.max' => 'Kode Mata Kuliah maksimal 10 karakter.',
    //         'kode_mk.unique' => 'Kode Mata Kuliah sudah digunakan, gunakan kode lain.',
    //         'nama_mk.required' => 'Nama Mata Kuliah wajib diisi.',
    //         'nama_mk.max' => 'Nama Mata Kuliah maksimal 255 karakter.',
    //         'nama_mk.unique' => 'Nama Mata Kuliah sudah digunakan.',
    //         'sks.required' => 'SKS wajib diisi.',
    //         'sks.between' => 'SKS harus berada dalam range 1 sampai 6.',
    //         'plot_semester.required' => 'Semester wajib diisi.',
    //         'plot_semester.between' => 'Semester harus berada dalam range 1 sampai 8.',
    //         'jenis.required' => 'Jenis Mata Kuliah wajib dipilih.',
    //         'jenis.in' => 'Jenis Mata Kuliah hanya dapat berupa "Wajib" atau "Pilihan".',
    //     ]);

    //     $matkul = MataKuliah::findOrfail($kode_mk);

    //     // Update data mata kuliah
    //     $matkul->update([
    //         'kode_mk' => $request->kode_mk,
    //         'nama_mk' => $request->nama_mk,
    //         'sks' => $request->sks,
    //         'plot_semester' => $request->plot_semester,
    //         'jenis' => $request->jenis,
    //     ]);

    //     return redirect()->route('manajemen-matkul-kaprodi')->with('success', 'Mata kuliah berhasil diperbarui.');
    // }
    // public function update(Request $request, $kode_mk)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'kode_mk' => 'required|string|max:10',
    //         'nama_mk' => 'required|string|max:255',
    //         'sks' => 'required|integer|between:1,6',
    //         'plot_semester' => 'required|integer|between:1,8',
    //         'jenis' => 'required|in:W,P',
    //     ]);

    //     // Cek jika data ditemukan
    //     $matkul = MataKuliah::where('kode_mk', $kode_mk)->first();
    //     if (!$matkul) {
    //         return redirect()->route('manajemen-matkul-kaprodi')->with('error', 'Data tidak ditemukan.');
    //     }

    //     // Update data
    //     $matkul->update([
    //         'kode_mk' => $request->kode_mk, // Kode MK boleh diganti
    //         'nama_mk' => $request->nama_mk,
    //         'sks' => $request->sks,
    //         'plot_semester' => $request->plot_semester,
    //         'jenis' => $request->jenis,
    //     ]);

    //     return redirect()->route('manajemen-matkul-kaprodi')->with('success', 'Mata Kuliah berhasil diperbarui.');
    // }
    public function update(Request $request, $kode_mk)
{
    // Debugging: Lihat input dan kode_mk
    // dd($kode_mk, $request->all());

    // Validasi input
    $validated = $request->validate([
        'kode_mk' => 'required|string|max:10|unique:matakuliah,kode_mk,' . $kode_mk . ',kode_mk',
        'nama_mk' => 'required|string|max:255',
        'sks' => 'required|integer|between:1,6',
        'plot_semester' => 'required|integer|between:1,8',
        'jenis' => 'required|in:W,P',
    ]);

    // Cari data berdasarkan kode_mk lama
    $matkul = MataKuliah::where('kode_mk', $kode_mk)->first();

    // Jika data tidak ditemukan
    if (!$matkul) {
        return redirect()->route('manajemen-matkul-kaprodi')->with('error', 'Mata Kuliah tidak ditemukan.');
    }

    // Update data
    $matkul->update([
        'kode_mk' => $request->kode_mk,
        'nama_mk' => $request->nama_mk,
        'sks' => $request->sks,
        'plot_semester' => $request->plot_semester,
        'jenis' => $request->jenis,
    ]);

    // Redirect ke halaman manajemen dengan pesan sukses
    return redirect()->route('manajemen-matkul-kaprodi')->with('success', 'Mata Kuliah berhasil diperbarui.');
}

    
    

    public function destroy($kode_mk, Request $request)
    {
        // Cari mata kuliah berdasarkan ID atau kode_mk
        $matkul = MataKuliah::findOrFail($kode_mk);

        // Hapus mata kuliah
        $matkul->delete();

        // Redirect ke halaman manajemen dengan pesan sukses
        return redirect()->route('manajemen-matkul-kaprodi')->with('success', 'Mata kuliah berhasil dihapus.');
    }

}
