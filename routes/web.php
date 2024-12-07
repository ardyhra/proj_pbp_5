<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\RuangController;


use App\Http\Controllers\DashboardControllerBA;
use App\Http\Controllers\UsulanController;

use App\Http\Controllers\DekanController;



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

// ========================================================================================================================

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

// ========================================================================================================================

// Pembimbing Akademik -- Doswal

Route::get('/dashboard-doswal', [DosenController::class, 'showAll'])->name('dashboard-doswal');

Route::get('/persetujuanIRS-doswal', [DosenController::class, 'showPersetujuan'])->name('persetujuanIRS-doswal');

Route::get('/rekap-doswal', [DosenController::class, 'showRekap'])->name('rekap-doswal');

Route::get('/rekap-doswal/informasi-irs/{nim}', [DosenController::class, 'showInformasi'])->name('rekap-doswal.informasi-irs');

Route::get('/rekap-doswal/informasi-irs-fromPersetujuan/{nim}', [DosenController::class, 'showInformasiLite'])->name('rekap-doswal.informasi-irs-fromPersetujuan');

Route::post('/irs/setuju/{nim}', [IrsController::class, 'approve'])->name('irs.approve');

Route::post('/irs/izin/{nim}', [IrsController::class, 'izin'])->name('irs.izin');

Route::get('/irs/filter', [IrsController::class, 'filter'])->name('irs.filter');

Route::get('/irs/filter/semester', [IrsController::class, 'filter_semester'])->name('irs.filter.semester');

Route::get('/irs/filter/dashboard', [IrsController::class, 'filter_dashboard'])->name('irs.filter.dashboard');

// Route::get('/dashboard-doswal/{nidn}', [DosenController::class, 'showAll'])->name('dashboard-doswal');

// Route::get('/persetujuanIRS-doswal/{nidn}', [DosenController::class, 'showPersetujuan'])->name('persetujuanIRS-doswal');

// Route::get('/rekap-doswal/{nidn}', [DosenController::class, 'showRekap'])->name('rekap-doswal');

// Route::get('/konsultasi-doswal/{nidn}', [DosenController::class, 'showKonsultasi'])->name('konsultasi-doswal');

// ========================================================================================================================

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

Route::get('/dashboard-ba', [DashboardControllerBA::class, 'index'])->name('dashboard-ba');
Route::get('/editruang', [RuangController::class, 'index'])->name('editruang');
Route::post('/editruang', [RuangController::class, 'store']);
Route::put('/editruang/{id}', [RuangController::class, 'update']);
Route::delete('/editruang/{id}', [RuangController::class, 'destroy']);



Route::get('/buatusulan', [UsulanController::class, 'create'])->name('buatusulan');
Route::post('/buatusulan', [UsulanController::class, 'store']);

Route::get('/daftarusulan', [UsulanController::class, 'index'])->name('daftarusulan');

Route::get('/get-usulan/{id_tahun}', [UsulanController::class, 'getUsulanByTahun']);
Route::get('/get-usulan-detail/{id_tahun}/{id_prodi}', [UsulanController::class, 'getUsulanDetail']);
Route::get('/get-usulan-data/{id_tahun}', [UsulanController::class, 'getUsulanData'])->name('usulan.getUsulanData');
Route::post('/usulan/{id_tahun}/update-status', [UsulanController::class, 'updateStatusUsulan'])->name('usulan.updateStatus');

// Mengupdate status usulan oleh dekan (disetujui atau ditolak)
// Route::patch('/usulan-ruang-kuliah/{id}/status', [UsulanController::class, 'updateStatus']);

// ========================================================================================================================

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

Route::get('/usulanruang', [DekanController::class, 'indexDekan'])->name('usulanruang.dekan');
Route::post('/usulanruang/{id_tahun}/update-status', [DekanController::class, 'updateStatusUsulanDekan'])->name('usulanruang.updateStatusDekan');
Route::get('/get-usulan/{id_tahun}', [DekanController::class, 'getUsulan'])->name('usulanruang.getUsulan');
Route::get('/get-usulan-detail/{id_tahun}/{id_prodi}', [DekanController::class, 'getUsulanDetail'])->name('usulanruang.getUsulanDetail');

// ========================================================================================================================
// Route untuk filter jadwal
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'kaprodi'])->name('jadwal.kaprodi');

// Route untuk melihat jadwal setelah filter
Route::get('/jadwal/view', [JadwalController::class, 'index'])->name('jadwal.view');


// Route untuk menampilkan form create jadwal
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');

// Route untuk menyimpan data jadwal
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');

Route::resource('jadwal', JadwalController::class);
Route::get('jadwal/kaprodi', [kaprodiController::class, 'kaprodi'])->name('jadwal.kaprodi');
// Route untuk Dashboard Kaprodi
Route::get('/dashboard-kaprodi', [KaprodiController::class, 'dashboard'])->name('dashboard-kaprodi');
// Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');

// Route untuk Manajemen Jadwal Kaprodi
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi.index');

// Route untuk tampilkan form edit
Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
//Route::get('/jadwal/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
// Route untuk update data jadwal ke database
Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
// Route untuk menghapus jadwal
//Route::get('/jadwal/view', [JadwalController::class, 'index'])->name('jadwal.view');
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');


// Route untuk Apply Jadwal
Route::get('/jadwal/apply', [KaprodiController::class, 'applyJadwal'])->name('jadwal.apply');
// Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');


// Route untuk Monitoring Kaprodi
Route::get('/monitoring-kaprodi', [KaprodiController::class, 'monitoring'])->name('monitoring-kaprodi');

// Route untuk Aksi "Lihat", "Edit", dan "Hapus"
// Route::get('/monitoring/view/{id}', [KaprodiController::class, 'viewMonitoring'])->name('monitoring.view');
// Route::get('/monitoring/edit/{id}', [KaprodiController::class, 'editMonitoring'])->name('monitoring.edit');
// Route::get('/monitoring/delete/{id}', [KaprodiController::class, 'deleteMonitoring'])->name('monitoring.delete');
// // routes/web.php

// Route::get('/monitoring/{id}', [MonitoringController::class, 'view'])->name('monitoring.view');
// Route::get('/monitoring/{id}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
// Route::delete('/monitoring/{id}', [MonitoringController::class, 'delete'])->name('monitoring.delete');

// Route konsultasi
Route::get('/konsultasi-kaprodi', [KaprodiController::class, 'konsultasi'])->name('konsultasi-kaprodi');
// Role Ganda

Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');

Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');

// ========================================================================================================================

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


//Route::get('/manajemen-jadwal', [JadwalController::class, 'index'])->name('manajemen-jadwal');


