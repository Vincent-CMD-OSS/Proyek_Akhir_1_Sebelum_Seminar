<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth; // Pastikan Auth di-import jika digunakan di callback rute '/'

// BAGIAN CONTROLLER ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilPantiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\OperasionalController;
use App\Http\Controllers\Admin\KebutuhanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\IdentitasPantiController;

// BAGIAN CONTROLLER USER
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProfilPantiPublicController;
use App\Http\Controllers\Public\GaleriPublicController;
use App\Http\Controllers\Public\OperasionalPublicController;
use App\Http\Controllers\Public\DonasiPublicController;
use App\Http\Controllers\Public\KebutuhanPublicController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {
    if (Auth::check()) { // Pastikan Auth sudah di-import
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Grup Rute untuk Autentikasi Admin
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')
        ->middleware('guest') // Tambahkan middleware 'guest' di sini
        ->name('login');

    Route::post('login', 'login')
        ->middleware('guest') // Tambahkan middleware 'guest' di sini
        ->name('login.submit');

    Route::post('logout', 'logout')
        ->middleware('auth')  // Tambahkan middleware 'auth' di sini
        ->name('logout.submit');
});


// Grup Rute untuk Area Admin yang Dilindungi Autentikasi
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::prefix('profil-panti')->name('profil.panti.')->group(function () {
        Route::get('edit', [ProfilPantiController::class, 'edit'])->name('edit');
        Route::put('update', [ProfilPantiController::class, 'update'])->name('update'); // Untuk profil panti utama

       // Struktur Organisasi Anggota
        Route::post('struktur', [ProfilPantiController::class, 'storeStrukturAnggota'])->name('struktur.store');
        Route::get('struktur/{strukturOrganisasiAnggota}/edit', [ProfilPantiController::class, 'editStrukturAnggota'])->name('struktur.edit');
        Route::put('struktur/{strukturOrganisasiAnggota}', [ProfilPantiController::class, 'updateStrukturAnggota'])->name('struktur.update');
        Route::delete('struktur/{strukturOrganisasiAnggota}', [ProfilPantiController::class, 'destroyStrukturAnggota'])->name('struktur.destroy');

        // Tim Pendiri Anggota
        Route::post('pendiri', [ProfilPantiController::class, 'storeTimPendiri'])->name('pendiri.store');
        Route::get('pendiri/{timPendiriAnggota}/edit', [ProfilPantiController::class, 'editTimPendiri'])->name('pendiri.edit');
        Route::put('pendiri/{timPendiriAnggota}', [ProfilPantiController::class, 'updateTimPendiri'])->name('pendiri.update');
        Route::delete('pendiri/{timPendiriAnggota}', [ProfilPantiController::class, 'destroyTimPendiri'])->name('pendiri.destroy');
    });

    Route::resource('galeri', GaleriController::class);

    // Operasional Routes
    Route::prefix('operasional')->name('operasional.')->group(function () {
        Route::get('/', [OperasionalController::class, 'index'])->name('index'); // Halaman utama operasional

        // CRUD Jadwal Harian (PENDEKATAN BARU)
        Route::prefix('harian')->name('harian.')->group(function () {
            // Route untuk menampilkan form pengaturan jadwal per hari
            Route::get('{hari}/atur', [OperasionalController::class, 'aturJadwalHarian'])
                 ->name('atur')
                 ->where('hari', '(senin|selasa|rabu|kamis|jumat|sabtu|minggu)'); // Parameter hari

            // Route untuk menyimpan perubahan jadwal per hari
            Route::post('{hari}/update', [OperasionalController::class, 'updateJadwalHarianPerHari'])
                 ->name('update.perhari')
                 ->where('hari', '(senin|selasa|rabu|kamis|jumat|sabtu|minggu)');
        });

        // CRUD Jadwal Khusus
        Route::prefix('khusus')->name('khusus.')->group(function () {
            Route::get('create', [OperasionalController::class, 'createKhusus'])->name('create');
            Route::post('/', [OperasionalController::class, 'storeKhusus'])->name('store');
            Route::get('{jadwalOperasionalKhusus}/edit', [OperasionalController::class, 'editKhusus'])->name('edit');
            Route::put('{jadwalOperasionalKhusus}', [OperasionalController::class, 'updateKhusus'])->name('update');
            Route::delete('{jadwalOperasionalKhusus}', [OperasionalController::class, 'destroyKhusus'])->name('destroy');
        });
    });

    // Kebutuhan Routes
    Route::resource('kebutuhan', KebutuhanController::class);

    // Route tambahan untuk mengelola penerimaan dana per kebutuhan
    Route::prefix('kebutuhan/{kebutuhan}/penerimaan')->name('kebutuhan.penerimaan.')->group(function () {
        Route::get('/', [KebutuhanController::class, 'indexPenerimaan'])->name('index'); // Menampilkan daftar penerimaan untuk kebutuhan_id
        Route::get('create', [KebutuhanController::class, 'createPenerimaan'])->name('create'); // Form tambah penerimaan
        Route::post('/', [KebutuhanController::class, 'storePenerimaan'])->name('store');
        Route::get('{penerimaanDanaKebutuhan}/edit', [KebutuhanController::class, 'editPenerimaan'])->name('edit');
        Route::put('{penerimaanDanaKebutuhan}', [KebutuhanController::class, 'updatePenerimaan'])->name('update');
        Route::delete('{penerimaanDanaKebutuhan}', [KebutuhanController::class, 'destroyPenerimaan'])->name('destroy');
    });

    Route::resource('donasi', DonasiController::class);

    // Identitas Panti Routes
    Route::prefix('identitas-panti')->name('identitas_panti.')->group(function () {
        Route::get('edit', [IdentitasPantiController::class, 'edit'])->name('edit');
        Route::put('update', [IdentitasPantiController::class, 'update'])->name('update');

        // Rute untuk manajemen foto
        Route::post('foto', [IdentitasPantiController::class, 'storeFoto'])->name('foto.store');
        Route::delete('foto/{foto}', [IdentitasPantiController::class, 'destroyFoto'])->name('foto.destroy');
        // Opsional: Jika ingin edit keterangan foto
        Route::get('foto/{foto}/edit-keterangan', [App\Http\Controllers\Admin\IdentitasPantiController::class, 'editFotoKeterangan'])->name('foto.keterangan.edit');
        Route::put('foto/{foto}/update-keterangan', [App\Http\Controllers\Admin\IdentitasPantiController::class, 'updateFotoKeterangan'])->name('foto.keterangan.update');
    });

});




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-panti', [ProfilPantiPublicController::class, 'index'])->name('public.profil_panti.index');
Route::get('/galeri-kegiatan', [GaleriPublicController::class, 'index'])->name('public.galeri.index');
// Route::get('/galeri-kegiatan/{galeri_item_id}/detail', [GaleriPublicController::class, 'showDetailJson'])->name('public.galeri.show.json');

Route::get('/galeri-kegiatan/{galeri}', [GaleriPublicController::class, 'show'])->name('public.galeri.show'); 

Route::get('/jadwal-operasional', [OperasionalPublicController::class, 'index'])->name('public.operasional.index');

Route::get('/galeri-kegiatan', [GaleriPublicController::class, 'index'])->name('public.galeri.index');
Route::get('/galeri-kegiatan/{identifier}', [GaleriPublicController::class, 'show'])->name('public.galeri.show');

Route::get('/operasional', [OperasionalPublicController::class, 'index'])->name('public.operasional.index');

Route::get('/donasi', [DonasiPublicController::class, 'index'])->name('public.donasi.index');
Route::post('/donasi/kirim-konfirmasi', [DonasiPublicController::class, 'kirimKonfirmasiWA'])->name('public.donasi.kirim'); // Untuk submit form

Route::get('/kebutuhan', [KebutuhanPublicController::class, 'index'])->name('public.kebutuhan.index');
Route::get('/kebutuhan/{slug}', [KebutuhanPublicController::class, 'show'])->name('public.kebutuhan.show');