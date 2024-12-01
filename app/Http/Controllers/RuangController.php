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

            if ($request->ajax()) {
                Log::info('Data ruang yang dikirim ke frontend:', $ruang->toArray()); // Log untuk debugging
                return response()->json($ruang);
            }

            return view('ba.editruang', compact('ruang'));
        }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_ruang' => 'required|unique:ruang|max:4',
            'blok_gedung' => 'required|max:1',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ]);

        $ruang = Ruang::create($validated);

        return response()->json([
            'message' => 'Ruang berhasil ditambahkan.',
            'ruang' => $ruang
        ], 201);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'id_ruang' => [
            'required',
            'max:4',
            Rule::unique('ruang')->ignore($id, 'id_ruang'),
        ],
        'blok_gedung' => 'required|max:1',
        'lantai' => 'required|integer',
        'kapasitas' => 'required|integer',
    ]);

    $ruang = Ruang::findOrFail($id);
    $ruang->update($validated);

    return response()->json([
        'message' => 'Ruang berhasil diperbarui.'
    ], 200);
}


    

    
    


    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();

        return response()->json([
            'message' => 'Ruang berhasil dihapus.'
        ], 200);
    }
}
