<?php

namespace App\Http\Controllers\Home;

use App\Models\Tanaman;
use App\Models\Komoditi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class KomoditiController extends Controller
{

    public function index(Tanaman $tanaman)
    {
        $komoditis = $tanaman->komoditi;

        $harga = [];
        $tanggal = [];

        // Ambil tanggal terbaru dari data komoditi
        $latestDate = $komoditis->max('tanggal'); // Dapatkan tanggal terbaru dari database

        // Hitung batas tanggal (1 bulan ke belakang)
        $oneMonthAgo = \Carbon\Carbon::parse($latestDate)->subDays(30)->format('Y-m-d');

        foreach ($komoditis as $komoditi) {
            if ($komoditi->tanggal >= $oneMonthAgo) { // Filter data hanya dalam rentang 30 hari
                $harga[] = number_format($komoditi->harga_provinsi, 1, '.', '');
                $tanggal[] = date('d M Y', strtotime($komoditi->tanggal));
            }
        }


        return view('home.komoditi.index', [
            'tanaman' => $tanaman,
            'harga' => json_encode($harga),
            'tanggal' => json_encode($tanggal),
            'komoditis' => $komoditis
        ]);
    }


    public function data()
    {
        // Mapping variant_id ke tanaman_id
        $tanamanMap = [
            52 => 1, // Padi
            9  => 2, // Cabai
            13 => 3  // Bawang Merah
        ];

        $variants = array_keys($tanamanMap);

        // Rentang waktu: 32 hari sebelum 2 hari lalu
        $endDate = Carbon::today()->subDays(2)->format('Y-m-d');
        $startDate = Carbon::parse($endDate)->subDays(32)->format('Y-m-d');

        $cacheKey = "harga_pangan_{$startDate}_{$endDate}";

        $categorizedData = Cache::remember($cacheKey, now()->addDay(), function () use ($startDate, $endDate, $variants, $tanamanMap) {
            $result = [];

            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                foreach ($variants as $variant_id) {
                    $url = "https://api-sp2kp.kemendag.go.id/report/api/average-price-public?level=1&tanggal=$currentDate&take=9999999&variant_id=$variant_id";

                    try {
                        $response = Http::timeout(10)->get($url);

                        if (!$response->ok()) {
                            Log::warning("Gagal ambil data variant_id $variant_id pada $currentDate. Status: " . $response->status());
                            continue;
                        }

                        $data = $response->json()['data'] ?? [];

                        foreach ($data as $item) {
                            if ($item['nama_provinsi'] === 'Jawa Tengah') {
                                $tanaman_id = $tanamanMap[$variant_id];

                                Komoditi::updateOrCreate(
                                    [
                                        'nama_provinsi' => $item['nama_provinsi'],
                                        'tanaman_id'    => $tanaman_id,
                                        'tanggal'       => $currentDate,
                                    ],
                                    [
                                        'harga_provinsi' => $item['harga']
                                    ]
                                );

                                $result[$tanaman_id][] = [
                                    'tanggal'        => $currentDate,
                                    'nama_provinsi'  => $item['nama_provinsi'],
                                    'harga_provinsi' => $item['harga'],
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Error API variant_id $variant_id ($currentDate): " . $e->getMessage());
                        continue;
                    }
                }

                $currentDate = Carbon::parse($currentDate)->addDay()->format('Y-m-d');
            }

            return $result;
        });

        // Debug
        dd($categorizedData);
    }
}
