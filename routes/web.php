<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

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
Route::get('/dashboard-doswal', function () {
    return view('doswal/dashboard-doswal');
})->name('dashboard-doswal');

Route::get('/persetujuanIRS-doswal', function () {
    return view('doswal/persetujuanIRS-doswal');
});

Route::get('/rekap-doswal', function () {
    return view('doswal/rekap-doswal');
});

Route::get('/nilai-doswal', function () {
    return view('doswal/nilai-doswal');
});



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

Route::get('/monitoring-kaprodi', function () {
    return view('kaprodi/monitoring-kaprodi');
});

Route::get('/konsultasi-kaprodi', function () {
    return view('kaprodi/konsultasi-kaprodi');
});


//? Testing

Route::get('/test', function () {
    return view('tailwind');
});

Route::get('/test2', function () {
    return view('dashboard-gakepake');
});



