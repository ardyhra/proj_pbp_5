<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Daftar semester ganjil dan genap
        $semesterList = [
            'ganjil' => '2023/2024 Ganjil',
            'genap' => '2023/2024 Genap',
        ];

        // Ambil parameter semester dari URL, default ke 'ganjil'
        $selectedSemester = $request->query('semester', 'ganjil'); // Default ke 'ganjil'

        // Validasi semester
        if (!array_key_exists($selectedSemester, $semesterList)) {
            abort(404, 'Semester tidak valid');
        }

        // Data jadwal untuk ganjil atau genap
        $semesterData = $selectedSemester === 'ganjil'
            ? [
                ['id' => 1, 'name' => 'Semester 1'],
                ['id' => 3, 'name' => 'Semester 3'],
                ['id' => 5, 'name' => 'Semester 5'],
                ['id' => 7, 'name' => 'Semester 7'],
            ]
            : [
                ['id' => 2, 'name' => 'Semester 2'],
                ['id' => 4, 'name' => 'Semester 4'],
                ['id' => 6, 'name' => 'Semester 6'],
                ['id' => 8, 'name' => 'Semester 8'],
            ];

        // Kirim data ke view
        return view('kaprodi.manajemen-jadwal-kaprodi', compact('semesterList', 'selectedSemester', 'semesterData'));
    }

    public function view(Request $request)
    {
        $semester = $request->query('semester');
        $section = $request->query('section');

        $jadwal = Jadwal::where('semester', $semester)
                        ->where('section', $section)
                        ->get();

        return view('jadwal.view-jadwal', compact('jadwal', 'semester', 'section'));
    }

    public function editJadwal($id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        return view('edit-jadwal', compact('jadwal'));
    }

    // public function edit($semester, $section)
    // {
    //     // Ambil data jadwal berdasarkan semester dan section
    //     $jadwal = Jadwal::where('semester', $semester)
    //                     ->where('section', $section)
    //                     ->get();

    //     // Return ke view edit-jadwal.blade.php dengan data jadwal
    //     return view('edit-jadwal', compact('jadwal', 'semester', 'section'));
    // }

    public function update(Request $request)
    {
        $jadwal = Jadwal::find($request->id);
        $jadwal->update($request->all());

        return redirect()->route('manajemen-jadwal-kaprodi', ['semester' => $request->semester]);
    }

    public function apply(Request $request)
    {
        // Logic untuk menandai jadwal sebagai "final"
        return back()->with('success', 'Jadwal berhasil di-apply.');
    }
}
