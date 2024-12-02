<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\RuangController;
use Illuminate\Http\Request;







Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
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

// Route::get('/editruang', function () {
//     return view('ba/editruang');
// })->name('editruang');;

Route::get('/editruang', [RuangController::class, 'index'])->name('editruang');
Route::post('/editruang', [RuangController::class, 'store']);
Route::put('/editruang/{id}', [RuangController::class, 'update']);
Route::delete('/editruang/{id}', [RuangController::class, 'destroy']);

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




// Route untuk Dashboard Kaprodi
Route::get('/dashboard-kaprodi', [KaprodiController::class, 'dashboard'])->name('dashboard-kaprodi');
// Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');

// Route untuk Manajemen Jadwal Kaprodi
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi.index');
// Route untuk View Jadwal
Route::get('/jadwal/{id}/view', [KaprodiController::class, 'viewJadwal'])->name('jadwal.view');

// Route untuk Edit Jadwal
Route::get('/jadwal/edit', [KaprodiController::class, 'editJadwal'])->name('jadwal.edit');

// Route untuk Apply Jadwal
Route::get('/jadwal/apply', [KaprodiController::class, 'applyJadwal'])->name('jadwal.apply');
// Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');


// Route untuk Monitoring Kaprodi
Route::get('/monitoring-kaprodi', [KaprodiController::class, 'monitoring'])->name('monitoring-kaprodi');

// Route untuk Aksi "Lihat", "Edit", dan "Hapus"
Route::get('/monitoring/view/{id}', [KaprodiController::class, 'viewMonitoring'])->name('monitoring.view');
Route::get('/monitoring/edit/{id}', [KaprodiController::class, 'editMonitoring'])->name('monitoring.edit');
Route::get('/monitoring/delete/{id}', [KaprodiController::class, 'deleteMonitoring'])->name('monitoring.delete');

// Route konsultasi
Route::get('/konsultasi-kaprodi', [KaprodiController::class, 'konsultasi'])->name('konsultasi-kaprodi');
// Role Ganda
Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');