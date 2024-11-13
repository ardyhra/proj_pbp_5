<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $tahunAjaran = TahunAjaran::latest()->first()->nama ?? "Data Tahun Ajaran Tidak Ada";
        $jumlahRuang = Ruang::count();
        $jumlahDosen = Dosen::count();
        $jumlahMataKuliah = MataKuliah::count();

        return response()->json([
            'tahunAjaran' => $tahunAjaran,
            'jumlahRuang' => $jumlahRuang,
            'jumlahDosen' => $jumlahDosen,
            'jumlahMataKuliah' => $jumlahMataKuliah,
        ]);
    }
}
