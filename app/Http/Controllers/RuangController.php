<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
class RuangController extends Controller
{
    public function index(Request $request)
    {
        $ruang = Ruang::all();

        // Check if the request expects JSON (AJAX request)
        if ($request->expectsJson()) {
            return response()->json($ruang);
        }

        // For regular requests, return the view
        return view('ba.editruang', compact('ruang'));
    }


    public function store(Request $request)
    {
        $cap = $request->kapasitas;
        if($cap<0){
            return response()->json(['message' => 'Kapasitas tidak boleh kurang dari 0']);
        }
        $validated = $request->validate([
            'id_ruang' => 'required|unique:ruang|max:4',
            'blok_gedung' => 'required|max:1',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer|min:0',
        ]);
        
        $ruang = Ruang::create($validated);

        return response()->json([
            'message' => 'Ruang berhasil ditambahkan.',
            'ruang' => $ruang
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $ruang = Ruang::findOrFail($id);

        $validatedData = $request->validate([
            'id_ruang' => 'required|max:10|unique:ruang,id_ruang,' . $ruang->id_ruang . ',id_ruang',
            'blok_gedung' => 'required|string|max:50',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ]);

        $ruang->update($validatedData);

        return response()->json(['message' => 'Ruang berhasil diperbarui']);
    }

    


    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();

        return response()->json(['message' => 'Ruang berhasil dihapus']);
    }

}
