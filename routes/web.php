<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuacaController;
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

Route::get('/marketplace', [MarketController::class, 'showProducts'])->name('products.index');
