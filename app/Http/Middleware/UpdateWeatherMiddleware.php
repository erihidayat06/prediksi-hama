<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class UpdateWeatherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah sudah update hari ini (gunakan cache agar tidak terlalu sering)
        if (!Cache::has('weather_last_update')) {
            // Jalankan perintah update
            Artisan::call('weather:update');

            // Simpan cache supaya hanya update 1 kali sehari
            Cache::put('weather_last_update', now()->toDateString(), now()->endOfDay());
        }

        return $next($request);
    }
}
