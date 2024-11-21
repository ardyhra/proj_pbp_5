<?php
namespace App\Http\Controllers;
use App\Models\Ruang;
use App\Models\Dosen;
use App\Models\MataKuliah;

class KaprodiController extends Controller
{
    public function index()
    {
        $jumlahRuang = Ruang::count();
        $jumlahDosen = Dosen::count();
        $jumlahMataKuliah = MataKuliah::count();

        return view('dashboard.kaprodi', compact('jumlahRuang', 'jumlahDosen', 'jumlahMataKuliah'));
    }

}


