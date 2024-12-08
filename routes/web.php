<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\MahasiswaController;

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
Route::get('/dashboard-mhs', [MahasiswaController::class, 'dashboard'])->name('dashboard-mhs');

Route::get('/pengisianirs-mhs', [MahasiswaController::class, 'pengisianIrs'])->name('pengisianirs-mhs');

Route::post('/tambah-irs', [IrsController::class, 'tambahIRS'])->name('tambah-irs');

Route::get('/irs-mhs', [MahasiswaController::class, 'irs'])->name('irs-mhs');

Route::get('/irs-mhs/get-irs-detail', [IrsController::class, 'getIrsDetail'])->name('getIrsDetail');



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
Route::post('/buatusulan-prodi', [UsulanController::class, 'storeProdi']);

Route::get('/get-usulan-by-tahun/{id_tahun}', [UsulanController::class, 'getUsulanByTahun']);
Route::get('/get-usulan-detail/{id_tahun}/{id_prodi}', [UsulanController::class, 'getUsulanDetail']);
Route::get('/get-usulan-data/{id_tahun}', [UsulanController::class, 'getUsulanData'])->name('usulan.getUsulanData');
Route::post('/usulan/{id_tahun}/update-status', [UsulanController::class, 'updateStatusUsulan'])->name('usulan.updateStatus');
Route::post('/usulan/{id_tahun}/{id_prodi}/update-status', [UsulanController::class, 'updateStatusUsulanProdi']);

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
Route::post('/usulanruang/{id_tahun}/{id_prodi}/update-status', [DekanController::class, 'updateStatusUsulanProdiDekan'])->name('usulanruang.updateStatusProdiDekan');

// ========================================================================================================================
// KETUA PROGRAM STUDI
// Route untuk Dashboard Kaprodi
Route::get('/dashboard-kaprodi', [KaprodiController::class, 'dashboard'])->name('dashboard-kaprodi');



// Route untuk filter jadwal
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'kaprodi'])->name('jadwal.kaprodi');

// Route untuk Manajemen Jadwal Kaprodi
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi.index');

//Route usulan jadwal ke dekan
Route::get('/jadwal/ajukan/{id_tahun}/{id_prodi}', [JadwalController::class, 'ajukanJadwal'])->name('jadwal.ajukan');

// Route untuk melihat jadwal setelah filter
Route::get('/jadwal/view', [JadwalController::class, 'index'])->name('jadwal.view');

// Route untuk menampilkan form create jadwal
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');

//Route untuk mengecek validasi kode_mk
Route::post('/jadwal/check-kode-mk', [JadwalController::class, 'checkKodeMk'])->name('jadwal.check-kode-mk');


// Route untuk menyimpan data jadwal
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
Route::post('jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');

//Route untuk mengakses jadwal
Route::resource('jadwal', JadwalController::class);
Route::get('jadwal/kaprodi', [kaprodiController::class, 'kaprodi'])->name('jadwal.kaprodi');

// Route untuk tampilkan form edit
Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');

// Route untuk update data jadwal ke database
Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');

// Route untuk menghapus jadwal
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

Route::post('/jadwal/check-conflict', [JadwalController::class, 'checkConflict'])->name('jadwal.check-conflict');
Route::post('/jadwal/check-duplicate', [JadwalController::class, 'checkDuplicate'])->name('jadwal.check-duplicate');

// ========================================================================================================================

// Role Ganda

Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');

Route::get('/switch-role', [RoleController::class, 'switchRole'])->name('switch.role');
