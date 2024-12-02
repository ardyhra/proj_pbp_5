<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DekanController;

use App\Http\Controllers\DosenController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UsulanController;


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

Route::post('/irs/setuju/{nim}', [IrsController::class, 'approve'])->name('irs.approve');

Route::post('/irs/izin/{nim}', [IrsController::class, 'izin'])->name('irs.izin');

Route::get('/irs/filter', [IrsController::class, 'filter'])->name('irs.filter');

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

// Halaman usulan ruang kuliah untuk Dekan
Route::get('/usulanruang', [DekanController::class, 'indexDekan'])->name('usulanruang.dekan');

// Mengupdate status usulan oleh Dekan
Route::post('/usulanruang/{id_tahun}/update-status', [DekanController::class, 'updateStatusUsulanDekan'])->name('usulanruang.updateStatusDekan');

// Endpoint untuk mendapatkan data usulan
Route::get('/get-usulan/{id_tahun}', [DekanController::class, 'getUsulan'])->name('usulanruang.getUsulan');

// Endpoint untuk mendapatkan detail usulan
Route::get('/get-usulan-detail/{id_tahun}/{id_prodi}', [DekanController::class, 'getUsulanDetail'])->name('usulanruang.getUsulanDetail');

// ========================================================================================================================

use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\DashboardControllerBA;

// Route untuk Dashboard Kaprodi
Route::get('/dashboard-kaprodi', [KaprodiController::class, 'dashboard'])->name('dashboard-kaprodi');
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');

// Route untuk Manajemen Jadwal Kaprodi
// Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'manajemenJadwal'])->name('manajemen-jadwal-kaprodi');
Route::get('/manajemen-jadwal-kaprodi', [KaprodiController::class, 'index'])->name('manajemen-jadwal-kaprodi.index');

// Route untuk Lihat, Edit, dan Apply Jadwal
Route::get('/jadwal/view', [JadwalController::class, 'view'])->name('jadwal.view');
// Route::get('/jadwal/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::post('/jadwal/apply', [JadwalController::class, 'apply'])->name('jadwal.apply');
Route::get('/edit-jadwal/{semester}/{section}', [JadwalController::class, 'edit'])->name('jadwal.edit');

//coba
// Route untuk Lihat Jadwal
Route::get('/jadwal/view/{id}', [JadwalController::class, 'view'])->name('jadwal.view');

// Route untuk Edit Jadwal
Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');

// Route untuk Update Jadwal
Route::post('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');

//batas coba


// Route CRUD Jadwal (jika memang diperlukan)
Route::get('/manajemen-jadwal/create', [KaprodiController::class, 'create'])->name('manajemen-jadwal.create');
Route::post('/manajemen-jadwal', [KaprodiController::class, 'store'])->name('manajemen-jadwal.store');
Route::delete('/manajemen-jadwal/{id}', [KaprodiController::class, 'destroy'])->name('manajemen-jadwal.destroy');



// Route untuk Monitoring Kaprodi
Route::get('/monitoring-kaprodi', [KaprodiController::class, 'monitoring'])->name('monitoring-kaprodi');

// Route untuk Aksi "Lihat", "Edit", dan "Hapus"
Route::get('/monitoring/view/{id}', [KaprodiController::class, 'viewMonitoring'])->name('monitoring.view');
Route::get('/monitoring/edit/{id}', [KaprodiController::class, 'editMonitoring'])->name('monitoring.edit');
Route::get('/monitoring/delete/{id}', [KaprodiController::class, 'deleteMonitoring'])->name('monitoring.delete');


Route::get('/manajemen-jadwal/edit/{id}', [KaprodiController::class, 'editJadwal'])->name('manajemen-jadwal.edit');
Route::post('/manajemen-jadwal/update/{id}', [KaprodiController::class, 'updateJadwal'])->name('manajemen-jadwal.update');

// Route untuk halaman edit jadwal
Route::get('/edit-jadwal', function (Illuminate\Http\Request $request) {
    $semester = $request->query('semester'); // Mengambil parameter 'semester'
    $section = $request->query('section');  // Mengambil parameter 'section'

    // Ambil data jadwal dari database (jika diperlukan)
    $jadwal = \App\Models\Jadwal::where('semester', $semester)->where('section', $section)->get();

    return view('kaprodi.edit-jadwal', compact('semester', 'section', 'jadwal'));
})->name('edit-jadwal');


Route::post('/update-jadwal', function (Request $request) {
    $jadwal = $request->all();

    // Simpan data ke database (contoh sederhana)
    foreach ($jadwal['mata_kuliah'] as $index => $namaMataKuliah) {
        \App\Models\Jadwal::where('id', $jadwal['id'][$index])
            ->update([
                'nama_mata_kuliah' => $namaMataKuliah,
                'waktu_mulai' => $jadwal['waktu_mulai'][$index],
                'waktu_selesai' => $jadwal['waktu_selesai'][$index],
            ]);
    }

    return redirect()->route('manajemen-jadwal-kaprodi.index')->with('success', 'Jadwal berhasil diperbarui!');
})->name('update-jadwal');

// Konsultasi
Route::get('/konsultasi-kaprodi', [KaprodiController::class, 'konsultasi'])->name('konsultasi-kaprodi');

// Role Ganda
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


Route::get('/manajemen-jadwal', [JadwalController::class, 'index'])->name('manajemen-jadwal');

