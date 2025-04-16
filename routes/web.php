<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RuangKuliahController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\JadwalIRSController;
use App\Http\Controllers\KaprodiMahasiswaController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\PembimbingAkademikController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::middleware('auth')->group(function () {
    //tampilan pilih role
    Route::post('/set-role', [LoginController::class, 'setRole'])->name('set-role');
    Route::get('/dashboard/{role}', function ($role) {
        return view("dashboard.{$role}"); 
    })->name('dashboard.role');
    
    // tampilan pilih role
    Route::get('/choose-role', [LoginController::class, 'showChooseRoleForm'])->name('choose-role');
    Route::get('/dashboard/{role}', [DashboardController::class, 'showDashboard'])->name('dashboard.role');

    // Dashboard Mahasiswa
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa');
    Route::get('/registrasi', [DashboardController::class, 'mahasiswaRegistrasi'])->name('registrasi');
    Route::get('/akademik', [DashboardController::class, 'mahasiswaAkademik'])->name('akademik');
    Route::get('/mahasiswa-irs', [MahasiswaController::class, 'mahasiswaIRS'])->name('mahasiswa.irs');
    Route::get('/search/mata-kuliah', [MataKuliahController::class, 'search']);
    Route::post('/add-to-selected', [MataKuliahController::class, 'addToSelectedList']);
    Route::post('/save-irs', [IRSController::class, 'save']);
    Route::get('/jadwal/{kode_mata_kuliah}', [JadwalController::class, 'getJadwal']);
    Route::post('/save-irs', [IRSController::class, 'saveIRS'])->name('save.irs');
    Route::get('/get-irs-data', [IRSController::class, 'getIRSData']);
    Route::post('/update-status', [MahasiswaController::class, 'updateStatus']);
    Route::get('/irs/{nim}', [IRSController::class, 'index']);
    Route::get('/cetak-irs/{semester}', [IRSController::class, 'cetakIrs'])->name('cetak.irs');
    Route::get('/perubahanIRS', [IRSController::class, 'perubahanIRS'])->name('mahasiswa.perubahanIRS');


    // Dashboard Ketua Prodi
    Route::get('/dashboard/ketua_prodi', [DashboardController::class, 'ketuaProdi'])->name('dashboard.ketua_prodi');
    Route::prefix('kaprodi')->middleware('auth')->name('kaprodi.')->group(function() {
        // Daftar mata kuliah
        Route::get('mata_kuliah', [MataKuliahController::class, 'index'])->name('mata_kuliah');    
        // Menambah mata kuliah
        Route::get('/mata_kuliah/create', [MataKuliahController::class, 'createMataKuliah'])->name('mata_kuliah.create');
        Route::post('/mata_kuliah', [MataKuliahController::class, 'storeMataKuliah'])->name('mata_kuliah.store');
        // Mengedit mata kuliah
        Route::get('/mata_kuliah/{kode_mata_kuliah}/edit', [MataKuliahController::class, 'editMataKuliah'])->name('mata_kuliah.edit');
        Route::put('/mata_kuliah/{kode_mata_kuliah}', [MataKuliahController::class, 'updateMataKuliah'])->name('mata_kuliah.update');
        // Menghapus mata kuliah
        Route::delete('/mata-kuliah/{kode_mata_kuliah}', [MataKuliahController::class, 'destroy'])->name('mata_kuliah.destroy');
        // Mahasiswa
        Route::get('/mahasiswa', [KaprodiMahasiswaController::class, 'index'])->name('mahasiswa');
        Route::get('/jadwal_kuliah', [DashboardController::class, 'kaprodiJadwalKuliah'])->name('jadwal_kuliah');
        Route::post('/jadwal_kuliah', [JadwalController::class, 'store'])->name('jadwal_kuliah.store');
        // Pop-up Dosen Pengampu
        Route::post('/simpan-dosen-pengampu', [JadwalController::class, 'simpanDosenPengampu'])->name('simpan_dosen_pengampu');
        Route::post('/dosen_pengampu/store/{mataKuliahId}', [JadwalController::class, 'storeDosenP'])->name('dosen_pengampu.store');
        // list jadwal
        Route::get('/jadwal_list', [JadwalController::class, 'index'])->name('jadwal_list');
    });
    Route::get('/get-sks/{mataKuliahId}', function($mataKuliahId) {
        $mataKuliah = App\Models\MataKuliah::find($mataKuliahId);
        if ($mataKuliah) {
            return response()->json(['sks' => $mataKuliah->jumlah_sks]);
        }
        return response()->json(['sks' => 0], 404);
    });

    // Dashboard Pembimbing Akademik
    Route::get('/dashboard/pembimbing_akademik', [DashboardController::class, 'pembimbingAkademik'])->name('dashboard.pembimbing_akademik');

    // Dashboard Bagian Akademik
        Route::get('/dashboard/bagian_akademik', [DashboardController::class, 'bagianAkademik'])->name('dashboard.bagian_akademik');

    // Rute untuk halaman index ruang kuliah
    Route::get('/ruang-kuliah', [RuangKuliahController::class, 'index'])->name('ruang-kuliah.index');

    // Rute untuk menampilkan detail ruang berdasarkan program studi
    Route::get('/ruang-kuliah/detail/{id}', [RuangKuliahController::class, 'show'])->name('ruang-kuliah.show');
    // Edit Ruang
    Route::get('/ruang-kuliah/{kodeRuang}/edit', [RuangKuliahController::class, 'edit'])->name('ruang-kuliah.edit');
    // Update Ruang
    Route::put('/ruang-kuliah/{kodeRuang}', [RuangKuliahController::class, 'update'])->name('ruang-kuliah.update');
    // Rute untuk menghapus data ruang
    Route::delete('/ruang-kuliah/{kodeRuang}', [RuangKuliahController::class, 'destroy'])->name('ruang-kuliah.destroy');
    // Rute untuk submit ruang ke atasan untuk persetujuan
    Route::post('/ruang-kuliah/submit/{id}', [RuangKuliahController::class, 'submit'])->name('ruang-kuliah.submit');
    // Rute untuk menampilkan form tambah ruang baru
    Route::get('/ruang-kuliah/create/{id}', [RuangKuliahController::class, 'create'])->name('ruang-kuliah.create');
    // Rute untuk menyimpan data ruang baru ke database
    Route::post('/ruang-kuliah', [RuangKuliahController::class, 'store'])->name('ruang-kuliah.store');
    
    // Dashboard Dekan
    // Route::middleware('role:dekan')->group(function () {
    Route::get('/dashboard/dekan', [DashboardController::class, 'dekan'])->name('dashboard.dekan');
    Route::get('/dekan/ruangan', [DekanController::class, 'index'])->name('dekan.ruangan'); 
    Route::get('/dekan/ruangan/detail/{id}', [DekanController::class, 'show'])->name('dekan.ruang-kuliah.show'); 
    Route::put('/dekan/ruangan/approve-all', [DekanController::class, 'approveAll'])->name('dekan.ruangan.approveAll');
    Route::put('/dekan/ruangan/reject-all', [DekanController::class, 'rejectAll'])->name('dekan.ruangan.rejectAll');
    Route::get('/dekan/jadwal', [DekanController::class, 'showJadwalPerProdi'])->name('dekan.JadwalPerProdi');
    Route::get('/dekan/jadwal/detail/{idProdi}', [DekanController::class, 'detailJadwalProdi'])->name('dekan.DetailJadwalProdi');

    //pembimbing akademik
    Route::get('/dashboard/pembimbing_akademik', [PembimbingAkademikController::class, 'dashboard'])->name('dashboard.pembimbing_akademik');
    
    Route::get('/pa/perwalian', [PembimbingAkademikController::class, 'index'])->name('pa.perwalian');
    Route::get('perwalian/detail/{id}', [PembimbingAkademikController::class, 'detail2'])->name('pa.detail');
    Route::get('perwalian/detailmahasiswa/{id}', [PembimbingAkademikController::class, 'detail'])->name('pa.detailmahasiswa');
    Route::post('perwalian/update-status/{id}/{status}', [PembimbingAkademikController::class, 'updateStatus'])->name('pa.updateStatus');
    Route::get('/cetak-irs/{nim}/{semester}', [PembimbingAkademikController::class, 'cetakIRS'])->name('pa.cetakIRS');
    Route::get('/detail/{nim}/irs', [PembimbingAkademikController::class, 'showIRS'])->name('pa.showIRS');
    Route::post('/pa/validasi-irs/{id}/{status}', [PembimbingAkademikController::class, 'validasiIrs'])->name('pa.validasiIrs');
    Route::get('/pa/ajuanIRS', [PembimbingAkademikController::class, 'ajuan'])->name('pa.ajuanIRS');

});
// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
