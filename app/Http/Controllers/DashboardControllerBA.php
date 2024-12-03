<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\UsulanRuangKuliah;
use App\Models\ProgramStudi;
use App\Models\Ruang;

class DashboardControllerBA extends Controller
{
    public function index()
    {
        // Total statistik
        $totalUsulan = UsulanRuangKuliah::distinct('id_tahun')->count('id_tahun'); // Hitung usulan per tahun ajaran
        $totalProgramStudi = ProgramStudi::count();
        $totalRuang = Ruang::count();

        // Rekap status usulan per tahun ajaran
        $rekapStatus = UsulanRuangKuliah::selectRaw('id_tahun, status, COUNT(DISTINCT id_tahun) as jumlah')
            ->groupBy('id_tahun', 'status')
            ->get()
            ->groupBy('status')
            ->map(fn($group) => $group->count());

        // Default status jika tidak ada data
        $rekapStatus = array_merge([
            'belum_diajukan' => 0,
            'diajukan' => 0,
            'disetujui' => 0,
            'ditolak' => 0,
        ], $rekapStatus->toArray());

        // Usulan terbaru
        $usulanTerbaru = UsulanRuangKuliah::with('programStudi', 'tahunAjaran')
            ->latest()
            ->take(10)
            ->get();

        return view('ba.dashboard-ba', compact(
            'totalUsulan',
            'totalProgramStudi',
            'totalRuang',
            'rekapStatus',
            'usulanTerbaru'
        ));
    }
}
