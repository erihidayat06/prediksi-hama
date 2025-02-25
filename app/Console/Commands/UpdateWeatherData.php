<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateWeatherData extends Command
{
    protected $signature = 'weather:update';
    protected $description = 'Update weather data daily for the next date';

    public function handle()
    {
        $kecamatanList = DB::table('weather_data')->select('kecamatan', 'latitude', 'longitude')->distinct()->get();
        $apiKey = env('WEATHER_API_KEY');

        // Ambil tanggal terakhir yang sudah ada di database
        $lastDate = DB::table('weather_data')->max('tanggal');

        if (!$lastDate) {
            $this->error("No existing weather data found. Run the initial data fetch first.");
            return;
        }

        // Tanggal yang akan diambil adalah tanggal setelah lastDate
        $newDate = Carbon::parse($lastDate)->addDay()->format('Y-m-d');

        // dd($newDate);

        foreach ($kecamatanList as $kecamatan) {
            $lat = $kecamatan->latitude;
            $lon = $kecamatan->longitude;
            $namaKecamatan = $kecamatan->kecamatan;

            $weatherData = Http::get("https://api.weatherapi.com/v1/forecast.json", [
                'key' => $apiKey,
                'q' => "{$lat},{$lon}",
                'days' => 1
            ])->json();

            if (!$weatherData || !isset($weatherData['forecast']['forecastday'][0]['day'])) continue;

            $dayData = $weatherData['forecast']['forecastday'][0]['day'];

            // Curah hujan min dan max (sementara, karena API tidak menyediakan nilai spesifik)
            $curahHujan = $dayData['totalprecip_mm'] ?? 0;
            $curahHujanMin = ($curahHujan == 0) ? 0 : ($curahHujan * 0.5); // Perkiraan minimum
            $curahHujanMax = $curahHujan; // Gunakan total sebagai maksimum

            DB::table('weather_data')->updateOrInsert(
                ['kecamatan' => $namaKecamatan, 'latitude' => $lat, 'longitude' => $lon, 'tanggal' => $newDate],
                [
                    'suhu_min' => $dayData['mintemp_c'] ?? 0,
                    'suhu_max' => $dayData['maxtemp_c'] ?? 0,
                    'suhu_optimum' => $dayData['avgtemp_c'] ?? 0,
                    'kelembapan_min' => $dayData['minhumidity'] ?? 0,
                    'kelembapan_max' => $dayData['maxhumidity'] ?? 0,
                    'kelembapan_optimum' => $dayData['avghumidity'] ?? 0,
                    'curah_hujan_min' => $curahHujanMin,
                    'curah_hujan_max' => $curahHujanMax,
                    'curah_hujan' => $curahHujan
                ]
            );
        }

        $this->info("Weather data updated for date: {$newDate}");
    }
}
