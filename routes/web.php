<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BioController;
use App\Http\Controllers\Admin\GapController;
use App\Http\Controllers\Admin\GolonganController;
use App\Http\Controllers\Admin\InsektisidaController;
use App\Http\Controllers\Admin\PanduanController;
use App\Http\Controllers\Admin\TanamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\Home\BioHamaController;
use App\Http\Controllers\Home\GapController as HomeGapController;
use App\Http\Controllers\Home\KomoditiController;
use App\Http\Controllers\Home\KondisiIklimController;
use App\Http\Controllers\Home\PanduanController as HomePanduanController;
use App\Http\Controllers\Home\PetaController;
use App\Http\Controllers\MarketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [CuacaController::class, 'home'])->name('cuaca')->middleware('weather.update');
Route::get('/informasi', [CuacaController::class, 'index'])->name('cuaca');
Route::get('/resistensi', [CuacaController::class, 'resitensi'])->name('cuaca');

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}', [TanamanController::class, 'index']);
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/gap', [TanamanController::class, 'gap']);
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/bio', [BioController::class, 'index'])->name('bio.index');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/bio/create', [BioController::class, 'create'])->name('bio.create');
Route::post('/admin/tanaman/{tanaman:nm_tanaman}/bio/store', [BioController::class, 'store'])->name('bio.store');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/bio/{bio:id}/edit', [BioController::class, 'edit'])->name('bio.edit');
Route::put('/admin/tanaman/{tanaman:nm_tanaman}/bio/{bio:id}', [BioController::class, 'update'])->name('bio.update');
Route::delete('/admin/tanaman/bio/{bio:id}', [BioController::class, 'destroy'])->name('bio.destroy');

// Gap
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/gap', [GapController::class, 'index'])->name('gap.index');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/gap/create', [GapController::class, 'create'])->name('gap.create');
Route::post('/admin/tanaman/{tanaman:nm_tanaman}/gap/store', [GapController::class, 'store'])->name('gap.store');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/gap/{gap:id}/edit', [GapController::class, 'edit'])->name('gap.edit');
Route::put('/admin/tanaman/{tanaman:nm_tanaman}/gap/{gap:id}', [GapController::class, 'update'])->name('gap.update');
Route::delete('/admin/tanaman/gap/{gap:id}', [GapController::class, 'destroy'])->name('gap.destroy');

// Panduan
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/panduan', [PanduanController::class, 'index'])->name('panduan.index');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/panduan/create', [PanduanController::class, 'create'])->name('panduan.create');
Route::post('/admin/tanaman/{tanaman:nm_tanaman}/panduan/store', [PanduanController::class, 'store'])->name('panduan.store');
Route::get('/admin/tanaman/{tanaman:nm_tanaman}/panduan/{gap:id}/edit', [PanduanController::class, 'edit'])->name('panduan.edit');
Route::put('/admin/tanaman/{tanaman:nm_tanaman}/panduan/{gap:id}', [PanduanController::class, 'update'])->name('panduan.update');
Route::delete('/admin/tanaman/panduan/{gap:id}', [PanduanController::class, 'destroy'])->name('panduan.destroy');

// Golongan
Route::resource('/admin/golongan', GolonganController::class);
Route::resource('/admin/insektisida', InsektisidaController::class);


// Home

//GAP
Route::get('/gap/{tanaman:nm_tanaman}', [HomeGapController::class, 'index']);

// Komoditi
Route::get('/info-komoditi/{tanaman:nm_tanaman}', [KomoditiController::class, 'index']);

// Panduan pestisida
Route::get('/panduan-pestisida/{tanaman:nm_tanaman}', [HomePanduanController::class, 'index']);

// Komoditi
Route::get('/komoditi', [KomoditiController::class, 'data']);

// Bio Informasi
Route::get('/bio-hama/{tanaman:nm_tanaman}', [BioHamaController::class, 'index']);

// Sebaran
Route::get('/sebaran-hama/{tanaman:nm_tanaman}', [PetaController::class, 'index']);

// Kondisi Iklim
Route::get('/kondisi-iklim/{tanaman:nm_tanaman}', [KondisiIklimController::class, 'index']);

Route::get('/marketplace', [MarketController::class, 'showProducts'])->name('products.index');
