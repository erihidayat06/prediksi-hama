<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Bio;
use App\Models\Blog;
use App\Models\User;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\PerubahanCuacaMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class CuacaController extends Controller
{
    public function index(Request $request)
    {

        $dataCuaca = dataCuaca()['weatherData'];
        $blogs = Blog::latest()->get();

        return view('cuaca', compact('dataCuaca', 'blogs'));
    }


    public function home()
    {
    //    $filePath = storage_path('app/data/kecamatan-brebes.json');

    //     if (!file_exists($filePath)) {
    //         return response()->json(['error' => 'File JSON tidak ditemukan'], 404);
    //     }

    //     $kecamatanBrebes = json_decode(file_get_contents($filePath), true);

    //     if (!$kecamatanBrebes) {
    //         return response()->json(['error' => 'File JSON tidak valid'], 500);
    //     }

    //     foreach ($kecamatanBrebes as $kecamatan) {

    //         $namaKecamatan = $kecamatan['kecamatan'] ?? null;
    //         $lat = $kecamatan['lat'] ?? null;
    //         $lon = $kecamatan['lon'] ?? null;

    //         if (!$namaKecamatan || !$lat || !$lon) {
    //             continue;
    //         }

    //         // =========================
    //         // WEATHER API
    //         // =========================
    //         $weatherResponse = Http::timeout(10)->get("https://api.weatherapi.com/v1/forecast.json", [
    //             'key' => env('WEATHER_API_KEY'),
    //             'q' => "{$lat},{$lon}",
    //             'days' => 7
    //         ]);

    //         if (!$weatherResponse->successful()) {
    //             \Log::error("Weather API gagal", [
    //                 'kecamatan' => $namaKecamatan,
    //                 'response' => $weatherResponse->body()
    //             ]);
    //             continue;
    //         }

    //         $weatherData = $weatherResponse->json();

    //         if (!isset($weatherData['forecast']['forecastday'])) {
    //             \Log::error("Format weather tidak sesuai", [
    //                 'kecamatan' => $namaKecamatan,
    //                 'data' => $weatherData
    //             ]);
    //             continue;
    //         }

    //         foreach ($weatherData['forecast']['forecastday'] as $day) {

    //             $tanggal = $day['date'] ?? null;
    //             $dayData = $day['day'] ?? null;

    //             if (!$tanggal || !$dayData) continue;

    //             $curahHujan = $dayData['totalprecip_mm'] ?? 0;

    //             DB::table('weather_data')->updateOrInsert(
    //                 [
    //                     'kecamatan' => $namaKecamatan,
    //                     'latitude' => $lat,
    //                     'longitude' => $lon,
    //                     'tanggal' => $tanggal
    //                 ],
    //                 [
    //                     'suhu_min' => $dayData['mintemp_c'] ?? 0,
    //                     'suhu_max' => $dayData['maxtemp_c'] ?? 0,
    //                     'suhu_optimum' => $dayData['avgtemp_c'] ?? 0,
    //                     'kelembapan_min' => $dayData['avghumidity'] ?? 0,
    //                     'kelembapan_max' => $dayData['avghumidity'] ?? 0,
    //                     'kelembapan_optimum' => $dayData['avghumidity'] ?? 0,
    //                     'curah_hujan_min' => $curahHujan * 0.5,
    //                     'curah_hujan_max' => $curahHujan,
    //                     'curah_hujan' => $curahHujan,
    //                     'updated_at' => now(),
    //                     'created_at' => now()
    //                 ]
    //             );
    //         }
    //     }

    //     dd('selesai');


        $tanamanList = ['padi', 'cabai', 'bawang-merah'];

        foreach ($tanamanList as $tanaman) {
            Tanaman::firstOrCreate(['nm_tanaman' => $tanaman]);
        }
        $blogs = Blog::latest()->paginate(5);

        $dataCuaca = dataCuaca(true)['weatherData'];
        $bios = Bio::get();
        return view('index', compact('dataCuaca', 'bios', 'blogs'));
    }

    public function bandingkanDataCuaca()
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        $dataCuacaSebelum = dataCuacaSebelum(true)['weatherData'];
        $perubahanHama = [];

        foreach ($dataCuaca as $index => $cuaca) {
            $kecamatan = $cuaca['kecamatan'];

            // Cari data cuaca sebelumnya berdasarkan kecamatan
            $cuacaSebelum = array_filter($dataCuacaSebelum, function ($item) use ($kecamatan) {
                return $item['kecamatan'] === $kecamatan;
            });

            if (!empty($cuacaSebelum)) {
                $cuacaSebelum = reset($cuacaSebelum);
                $hamaCuaca = $cuaca['rata_rata']['hama'];
                $hamaCuacaSebelum = $cuacaSebelum['rata_rata']['hama'];

                $perubahan = [];

                // Cek perubahan Hama cabai
                if ($hamaCuaca['cabai'] !== $hamaCuacaSebelum['cabai']) {
                    $perubahan['cabai'] = "Hama cabai berubah dari {$hamaCuacaSebelum['cabai']} ke {$hamaCuaca['cabai']}";
                }

                // Cek perubahan Hama padi
                if ($hamaCuaca['padi'] !== $hamaCuacaSebelum['padi']) {
                    $perubahan['padi'] = "Hama padi berubah dari {$hamaCuacaSebelum['padi']} ke {$hamaCuaca['padi']}";
                }

                // Cek perubahan Hama bawang merah
                if ($hamaCuaca['bawang-merah'] !== $hamaCuacaSebelum['bawang-merah']) {
                    $perubahan['bawang-merah'] = "Hama bawang merah berubah dari {$hamaCuacaSebelum['bawang-merah']} ke {$hamaCuaca['bawang-merah']}";
                }

                // Simpan hanya jika ada perubahan
                if (!empty($perubahan)) {
                    $perubahanHama[$kecamatan] = $perubahan;
                }
            }
        }

        return $perubahanHama; // Hanya mengembalikan data yang berubah
    }


    public function resitensi()
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        return view('resitensi', compact('dataCuaca'));
    }
}
