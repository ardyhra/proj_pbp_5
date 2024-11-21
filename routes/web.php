<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;




Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);

//! Default route
// Route::get('/', function () {
//     return view('login');
// });


// Semua User
Route::get('/about', function () {
    return view('about');
});

// Mahasiswa
Route::get('/dashboard-mhs', function () {
    return view('mhs/dashboard-mhs');
})->name('dashboard-mhs');
Route::get('/pengisianirs-mhs', function () {
    return view('mhs/pengisianirs-mhs');
});
Route::get('/irs-mhs', function () {
    return view('mhs/irs-mhs');
});

// Pembimbing Akademik -- Doswal
Route::get('/dashboard-doswal/{nidn}', [DosenController::class, 'showAll'])->name('dashboard-doswal');

Route::get('/persetujuanIRS-doswal/{nidn}', [DosenController::class, 'showPersetujuan'])->name('persetujuanIRS-doswal');

Route::get('/rekap-doswal/{nidn}', [DosenController::class, 'showRekap'])->name('rekap-doswal');

Route::get('/konsultasi-doswal/{nidn}', [DosenController::class, 'showKonsultasi'])->name('konsultasi-doswal');

// Bagian Akademik
Route::get('/dashboard-ba', function () {
    return view('ba/dashboard-ba');
})->name('dashboard-ba');

Route::get('/buatusulan', function () {
    return view('ba/buatusulan');
});

Route::get('/daftarusulan', function () {
    return view('ba/daftarusulan');
});

// Dekan
Route::get('/dashboard-dekan', function () {
    return view('dekan/dashboard-dekan');
})->name('dashboard-dekan');

Route::get('/aturgelombang', function () {
    return view('dekan/aturgelombang');
});

Route::get('/usulanruang', function () {
    return view('dekan/usulanruang');
});

Route::get('/usulanjadwal', function () {
    return view('dekan/usulanjadwal');
});

// Ketua Program Studi
Route::get('/dashboard-kaprodi', function () {
    return view('kaprodi/dashboard-kaprodi');
})->name('dashboard-kaprodi');

Route::get('/manajemen-jadwal-kaprodi', function () {
    return view('kaprodi/manajemen-jadwal-kaprodi');
});
//Route::get('/manajemen-jadwal-kaprodi', [AuthController::class, 'manajemen-jadwal-kaprodi'])->name('manajemen-jadwal-kaprodi');

Route::get('/monitoring-kaprodi', function () {
    return view('kaprodi/monitoring-kaprodi');
});

Route::get('/konsultasi-kaprodi', function () {
    return view('kaprodi/konsultasi-kaprodi');
});

// Role Ganda
Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');


// //? Testing

// Route::get('/test', function () {
//     return view('tailwind');
// });

// Route::get('/test2', function () {
//     return view('dashboard-gakepake');
// });



// use App\Http\Controllers\DashboardController;
// Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData']);

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// routes/web.php


Route::get('/manajemen-jadwal', [JadwalController::class, 'index'])->name('manajemen-jadwal');
