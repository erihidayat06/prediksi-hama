<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Komoditi;
use App\Models\Tanaman;
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

        $variants = array_keys($tanamanMap); // Ambil variant_id dari mapping

        // Tentukan endDate sebagai 2 hari ke belakang
        $endDate = Carbon::today()->subDays(2)->format('Y-m-d');
        // Tentukan startDate sebagai 7 hari dari endDate
        $startDate = Carbon::parse($endDate)->subDays(32)->format('Y-m-d');

        // Nama cache key
        $cacheKey = "harga_pangan_{$startDate}_{$endDate}";

        // Gunakan cache untuk menyimpan data selama 1 hari
        $categorizedData = Cache::remember($cacheKey, now()->addDay(), function () use ($startDate, $endDate, $variants, $tanamanMap) {
            $result = [];

            // Looping setiap tanggal dalam rentang waktu
            $currentDate = $startDate;
            while ($currentDate <= $endDate) {
                foreach ($variants as $variant_id) {
                    $url = "https://api-sp2kp.kemendag.go.id/report/api/average-price-public?level=1&tanggal=$currentDate&take=9999999&variant_id=$variant_id";

                    $response = Http::get($url);
                    $data = $response->json()['data'] ?? []; // Pastikan data tidak null

                    // Filter hanya data dari Jawa Tengah
                    foreach ($data as $item) {
                        if ($item['nama_provinsi'] === 'Jawa Tengah') {
                            $tanaman_id = $tanamanMap[$variant_id];

                            // Simpan ke database dengan tanggal yang berbeda
                            Komoditi::updateOrCreate(
                                [
                                    'nama_provinsi' => $item['nama_provinsi'],
                                    'tanaman_id'    => $tanaman_id,
                                    'tanggal'       => $currentDate, // Simpan tanggalnya
                                ],
                                [
                                    'harga_provinsi' => $item['harga']
                                ]
                            );

                            $result[$tanaman_id][] = [
                                'tanggal'       => $currentDate,
                                'nama_provinsi' => $item['nama_provinsi'],
                                'harga_provinsi' => $item['harga'],
                            ];
                        }
                    }
                }

                // Tambah satu hari ke tanggal saat ini
                $currentDate = Carbon::parse($currentDate)->addDay()->format('Y-m-d');
            }

            return $result;
        });

        dd($categorizedData); // Debug hasilnya
    }
}
