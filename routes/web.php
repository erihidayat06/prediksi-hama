<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\Admin\BioController;
use App\Http\Controllers\Admin\GapController;
use App\Http\Controllers\Admin\NewController;
use App\Http\Controllers\Home\PetaController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Home\BioHamaController;
use App\Http\Controllers\Admin\PanduanController;
use App\Http\Controllers\Admin\TanamanController;
use App\Http\Controllers\Home\KomoditiController;
use App\Http\Controllers\Admin\GolonganController;
use App\Http\Controllers\Admin\InsektisidaController;
use App\Http\Controllers\Home\KondisiIklimController;
use App\Http\Controllers\Home\GapController as HomeGapController;
use App\Http\Controllers\Home\BlogController as HomeBlogController;
use App\Http\Controllers\Home\PanduanController as HomePanduanController;

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





Route::middleware(['auth', 'is_admin'])->group(
    function () {
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

        Route::resource('/admin/blog', BlogController::class);
    }
);

// Home


Route::get('/', [CuacaController::class, 'home'])->name('cuaca')->middleware('weather.update');
Route::get('/informasi', [CuacaController::class, 'index'])->name('cuaca');
Route::get('/resistensi', [CuacaController::class, 'resitensi'])->name('cuaca');
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

// Berita
Route::get('/blog', [HomeBlogController::class, 'index']);
Route::get('/blog/{blog:slug}', [HomeBlogController::class, 'show'])->name('blog.show.home');

Route::get('/marketplace', [MarketController::class, 'index'])->name('produk.index');
Route::get('/marketplace/show/{produk:slug}', [MarketController::class, 'showProducts'])->name('produk.show');
Route::get('/produk/cari', [MarketController::class, 'cari'])->name('produk.cari');

Route::middleware(['auth'])->group(
    function () {
        Route::get('/marketplace/jual', [MarketController::class, 'jualProducts']);
        Route::get('/marketplace/produk-saya', [MarketController::class, 'Products'])->name('produk.saya');
        // Route untuk form edit
        Route::get('/marketplace/produk-saya/edit/{produk:id}', [MarketController::class, 'edit'])->name('produk.edit');

        // Route untuk submit form update
        Route::put('/marketplace/produk-saya/{produk:id}', [MarketController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [MarketController::class, 'destroy'])->name('produk.destroy');

        Route::patch('/produk/{id}/toggle-status', [MarketController::class, 'toggleStatus'])->name('produk.toggleStatus');

        Route::post('/marketplace/store', [MarketController::class, 'store'])->name('produk.store');

        Route::post('/cart/add/{id}', [MarketController::class, 'add'])->name('cart.add');
        Route::get('/cart/data', [MarketController::class, 'getCartData']);
        Route::post('/cart/remove/{id}', [MarketController::class, 'remove']);
        Route::get('/cart/check/{id}', [MarketController::class, 'checkCart']);
    }
);



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
