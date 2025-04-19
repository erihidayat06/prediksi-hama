<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class UpdateWeatherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jalankan hanya sekali per hari saat user mengakses website
        if (!Cache::has('daily_commands_ran')) {
            // Jalankan semua perintah harian
            Artisan::call('weather:update');
            Artisan::call('fetch:harga-pangan');
            // Artisan::call('cuaca:kirim-peringatan');

            // Simpan cache agar tidak dijalankan ulang sampai besok
            Cache::put('daily_commands_ran', now()->toDateString(), now()->endOfDay());

            Log::info('Middleware menjalankan perintah harian pada ' . now());
        }

        return $next($request);
    }
}
