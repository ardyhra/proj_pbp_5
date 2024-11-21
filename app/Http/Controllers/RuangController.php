<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $ruang = Ruang::all();

        return view('ba.editruang', compact('ruang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruang' => 'required|unique:ruang|max:4',
            'blok_gedung' => 'required|max:1',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ]);

        Ruang::create($request->all());
        return redirect()->route('editruang')->with('success', 'Ruang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_ruang' => 'required|max:4',
            'blok_gedung' => 'required|max:1',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ]);

        $ruang = Ruang::findOrFail($id);

        // Set nilai baru
        $ruang->id_ruang = $request->id_ruang;
        $ruang->blok_gedung = $request->blok_gedung;
        $ruang->lantai = $request->lantai;
        $ruang->kapasitas = $request->kapasitas;

        // Beri tahu Eloquent bahwa primary key asli adalah $id
        $ruang->setOriginal('id_ruang', $id);

        // Simpan perubahan
        $ruang->save();

        return response()->json(['message' => 'Ruang berhasil diperbarui'], 200);
    }


    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();
        return redirect()->route('editruang')->with('success', 'Ruang berhasil dihapus.');
    }
}

