<?php

// app/Http/Controllers/JadwalController.php
namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $ganjil = Jadwal::where('semester', 'ganjil')->get();
        $genap = Jadwal::where('semester', 'genap')->get();
        
        return view('jadwal.index', compact('ganjil', 'genap'));
    }
}

