<?php

use App\Models\WeatherData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

if (!function_exists('dataCuaca')) {
    function dataCuaca()
    {
        $filePath = storage_path('app/data/kecamatan-brebes.json');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File JSON tidak ditemukan'], 404);
        }

        $kecamatanBrebes = json_decode(file_get_contents($filePath), true);
        if (!$kecamatanBrebes) {
            return response()->json(['error' => 'File JSON tidak valid'], 500);
        }

        $kota = 'Brebes'; // Default kota
        $apiKey = env('WEATHER_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key tidak ditemukan'], 500);
        }

        $weatherData = [];

        foreach ($kecamatanBrebes as $kecamatan) {
            $namaKecamatan = $kecamatan['kecamatan'];

            // Inisialisasi total dan jumlah hari
            $totalSuhuMin = $totalSuhuMax = $totalSuhuOptimum = 0;
            $totalKelembapanMin = $totalKelembapanMax = $totalKelembapanOptimum = 0;
            $curahHujanData = [];
            $jumlahHari = 0; // Menghitung jumlah hari yang ditemukan
            // Mulai dari hari ini
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addDays(14); // Sampai 14 hari ke depan
            // Loop dari hari ini sampai 2 minggu ke depan
            while ($startDate->lte($endDate)) {
                $formattedDate = $startDate->format('Y-m-d');

                // Ambil data cuaca untuk tanggal itu
                $data = WeatherData::where('kecamatan', $namaKecamatan)
                    ->whereDate('tanggal', $formattedDate)
                    ->get();

                if (!$data->isEmpty()) {
                    foreach ($data as $item) {
                        $totalSuhuMin += $item->suhu_min ?? 0;
                        $totalSuhuMax += $item->suhu_max ?? 0;
                        $totalSuhuOptimum += $item->suhu_optimum ?? 0;

                        $totalKelembapanMin += $item->kelembapan_min ?? 0;
                        $totalKelembapanMax += $item->kelembapan_max ?? 0;
                        $totalKelembapanOptimum += $item->kelembapan_optimum ?? 0;

                        $curahHujanData[] = $item->curah_hujan ?? 0;
                    }

                    $jumlahHari += $data->count();
                }

                $startDate->addDay(); // Maju ke hari berikutnya
            }
            // Menghitung rata-rata dan nilai min/max curah hujan
            $curahHujanMin = count($curahHujanData) > 0 ? min($curahHujanData) : 0;
            $curahHujanMax = count($curahHujanData) > 0 ? max($curahHujanData) : 0;
            $curahHujanOptimum = count($curahHujanData) > 0 ? array_sum($curahHujanData) / count($curahHujanData) : 0;

            $hama_kriteria = [
                'cabai' => [
                    'Thrips' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 20, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 80, 'opt_min' => 50, 'opt_max' => 70],
                        'curah_hujan' => ['min' => 600, 'max' => 1200, 'opt_min' => 800, 'opt_max' => 1000],
                        'color' => "merah-color"
                    ],
                    'Kutu kebul' => [
                        'suhu' => ['min' => 15, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 500, 'max' => 1500, 'opt_min' => 800, 'opt_max' => 2000],
                        'color' => "hijau-color"
                    ],
                    'Lalat Buah' => [
                        'suhu' => ['min' => 12, 'max' => 35, 'opt_min' => 20, 'opt_max' => 28],
                        'kelembaban' => ['min' => 60, 'max' => 90, 'opt_min' => 70, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 2000, 'opt_min' => 1000, 'opt_max' => 1500],
                        'color' => "oren-color"
                    ],
                ],
                'padi' => [
                    'Wereng' => [
                        'suhu' => ['min' => 15, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 60, 'max' => 90, 'opt_min' => 60, 'opt_max' => 90],
                        'curah_hujan' => ['min' => 500, 'max' => 2500, 'opt_min' => 1200, 'opt_max' => 2000],
                        'color' => "merah-color"
                    ],
                    'Penggerek batang padi' => [
                        'suhu' => ['min' => 15, 'max' => 37, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 60, 'max' => 95, 'opt_min' => 70, 'opt_max' => 95],
                        'curah_hujan' => ['min' => 800, 'max' => 2000, 'opt_min' => 1200, 'opt_max' => 1800],
                        'color' => "hijau-color"
                    ],
                    'Walang sangit' => [
                        'suhu' => ['min' => 18, 'max' => 35, 'opt_min' => 28, 'opt_max' => 32],
                        'kelembaban' => ['min' => 50, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 2000, 'opt_min' => 1000, 'opt_max' => 2000],
                        'color' => "oren-color"
                    ],
                ],
                'bawang-merah' => [
                    'Thrips' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 500, 'max' => 1500, 'opt_min' => 1200, 'opt_max' => 1500],
                        'color' => "merah-color"
                    ],
                    'Ulat Bawang Merah' => [
                        'suhu' => ['min' => 13, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 1800, 'opt_min' => 1000, 'opt_max' => 1800],
                        'color' => "hijau-color"
                    ],
                    'Moler' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 20, 'opt_max' => 28],
                        'kelembaban' => ['min' => 60, 'max' => 95, 'opt_min' => 80, 'opt_max' => 90],
                        'curah_hujan' => ['min' => 800, 'max' => 2000, 'opt_min' => 1200, 'opt_max' => 1800],
                        'color' => "oren-color"
                    ],
                ],
            ];


            if ($jumlahHari > 0) {
                $rataCuaca = [
                    'suhu' => [
                        'min' => round($totalSuhuMin / $jumlahHari, 1),
                        'max' => round($totalSuhuMax / $jumlahHari, 1),
                        'optimum' => round($totalSuhuOptimum / $jumlahHari, 1),
                    ],
                    'kelembapan' => [
                        'min' => isset($totalKelembapanMin) ? round($totalKelembapanMin / $jumlahHari, 1) : 0,
                        'max' => isset($totalKelembapanMax) ? round($totalKelembapanMax / $jumlahHari, 1) : 0,
                        'optimum' => isset($totalKelembapanOptimum) ? round($totalKelembapanOptimum / $jumlahHari, 1) : 0,
                    ],
                    'curah_hujan' => [
                        'min' => round($curahHujanMin, 1) * 70,
                        'max' => round($curahHujanMax, 1) * 70,
                        'optimum' => round($curahHujanOptimum, 1) * 70,
                    ],
                ];


                $hamaTerdekat = [];
                $skorTertinggi = [];
                $colorTertinggi = [];

                foreach ($hama_kriteria as $tanaman => $hamaList) {
                    $hamaTerdekat[$tanaman] = null;
                    $skorTertinggi[$tanaman] = 0;

                    foreach ($hamaList as $namaHama => $kriteria) {
                        $skor = 0;

                        // Cek suhu
                        if ($rataCuaca['suhu']['optimum'] >= $kriteria['suhu']['opt_min'] && $rataCuaca['suhu']['optimum'] <= $kriteria['suhu']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['suhu']['optimum'] >= $kriteria['suhu']['min'] && $rataCuaca['suhu']['optimum'] <= $kriteria['suhu']['max']) {
                            $skor += 1;
                        }

                        // Cek kelembapan
                        if ($rataCuaca['kelembapan']['optimum'] >= $kriteria['kelembaban']['opt_min'] && $rataCuaca['kelembapan']['optimum'] <= $kriteria['kelembaban']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['kelembapan']['optimum'] >= $kriteria['kelembaban']['min'] && $rataCuaca['kelembapan']['optimum'] <= $kriteria['kelembaban']['max']) {
                            $skor += 1;
                        }

                        // Cek curah hujan
                        if ($rataCuaca['curah_hujan']['optimum'] >= $kriteria['curah_hujan']['opt_min'] && $rataCuaca['curah_hujan']['optimum'] <= $kriteria['curah_hujan']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['curah_hujan']['optimum'] >= $kriteria['curah_hujan']['min'] && $rataCuaca['curah_hujan']['optimum'] <= $kriteria['curah_hujan']['max']) {
                            $skor += 1;
                        }

                        // Simpan hama dengan skor tertinggi per tanaman
                        if ($skor > $skorTertinggi[$tanaman]) {
                            $skorTertinggi[$tanaman] = $skor;
                            $hamaTerdekat[$tanaman] = $namaHama;
                            $colorTerdekat[$tanaman] = $kriteria['color'];
                        }
                    }
                }

                $weatherData[] = [
                    'kecamatan' => $namaKecamatan,
                    'rata_rata' => [
                        'suhu' => [
                            'min' => $rataCuaca['suhu']['min'] . "°C",
                            'max' => $rataCuaca['suhu']['max'] . "°C",
                            'optimum' => $rataCuaca['suhu']['optimum'] . "°C",
                        ],
                        'kelembapan' => [
                            'min' => $rataCuaca['kelembapan']['min'] . "%",
                            'max' => $rataCuaca['kelembapan']['max'] . "%",
                            'optimum' => $rataCuaca['kelembapan']['optimum'] . "%",
                        ],
                        'curah_hujan' => [
                            'min' => $rataCuaca['curah_hujan']['min'] . " mm",
                            'max' => $rataCuaca['curah_hujan']['max'] . " mm",
                            'optimum' => $rataCuaca['curah_hujan']['optimum'] . " mm",
                        ],
                        'hama' => $hamaTerdekat, // Hasil akhir berupa array per tanaman
                        'color' => $colorTerdekat, // Hasil akhir berupa array per tanaman
                    ],
                ];
            }
        }


        // Menghitung hari Senin berikutnya
        $firstMonday = Carbon::now('UTC')->next(Carbon::MONDAY); // Senin pertama setelah hari ini
        $secondMonday = $firstMonday->copy()->addWeeks(1); // Senin kedua setelah 2 minggu

        // Format tanggal untuk hari Senin berikutnya
        $secondMondayFormatted = $secondMonday->format('Y-m-d');

        return ['weatherData' => $weatherData, 'kota' => $kota, 'kecamatanBrebes' => $kecamatanBrebes, 'nextMonday' => $secondMondayFormatted];
    }
}


if (!function_exists('dataCuacaSebelum')) {
    function dataCuacaSebelum()
    {
        $filePath = storage_path('app/data/kecamatan-brebes.json');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File JSON tidak ditemukan'], 404);
        }

        $kecamatanBrebes = json_decode(file_get_contents($filePath), true);
        if (!$kecamatanBrebes) {
            return response()->json(['error' => 'File JSON tidak valid'], 500);
        }

        $kota = 'Brebes'; // Default kota
        $apiKey = env('WEATHER_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key tidak ditemukan'], 500);
        }

        $weatherData = [];

        foreach ($kecamatanBrebes as $kecamatan) {
            $namaKecamatan = $kecamatan['kecamatan'];

            // Inisialisasi total dan jumlah hari
            $totalSuhuMin = $totalSuhuMax = $totalSuhuOptimum = 0;
            $totalKelembapanMin = $totalKelembapanMax = $totalKelembapanOptimum = 0;
            $curahHujanData = [];
            $jumlahHari = 0; // Menghitung jumlah hari yang ditemukan

            // Menentukan tanggal awal: 2 minggu sebelum hari ini
            $startDate = Carbon::now();
            $endLoopDate = Carbon::now()->addDays(13); // 14 hari total (hari ini + 13)

            // Ambil data setiap rentang 14 hari (tapi endDate = +13 hari, biar total 14 hari)
            while ($startDate->lte($endLoopDate)) {
                $startFormattedDate = $startDate->format('Y-m-d');

                // Ambil data cuaca untuk tanggal itu
                $data = WeatherData::where('kecamatan', $namaKecamatan)
                    ->where('tanggal', $startFormattedDate)
                    ->get();

                if (!$data->isEmpty()) {
                    foreach ($data as $item) {
                        $totalSuhuMin += $item->suhu_min ?? 0;
                        $totalSuhuMax += $item->suhu_max ?? 0;
                        $totalSuhuOptimum += $item->suhu_optimum ?? 0;

                        $totalKelembapanMin += $item->kelembapan_min ?? 0;
                        $totalKelembapanMax += $item->kelembapan_max ?? 0;
                        $totalKelembapanOptimum += $item->kelembapan_optimum ?? 0;

                        $curahHujanData[] = $item->curah_hujan ?? 0;
                    }

                    $jumlahHari += $data->count();
                }

                // Tambahkan 1 hari ke startDate untuk next loop
                $startDate->addDay();
            }
            // Menghitung rata-rata dan nilai min/max curah hujan
            $curahHujanMin = count($curahHujanData) > 0 ? min($curahHujanData) : 0;
            $curahHujanMax = count($curahHujanData) > 0 ? max($curahHujanData) : 0;
            $curahHujanOptimum = count($curahHujanData) > 0 ? array_sum($curahHujanData) / count($curahHujanData) : 0;

            $hama_kriteria = [
                'cabai' => [
                    'Thrips' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 20, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 80, 'opt_min' => 50, 'opt_max' => 70],
                        'curah_hujan' => ['min' => 600, 'max' => 1200, 'opt_min' => 800, 'opt_max' => 1000],
                        'color' => "merah-color"
                    ],
                    'Kutu kebul' => [
                        'suhu' => ['min' => 15, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 500, 'max' => 1500, 'opt_min' => 800, 'opt_max' => 2000],
                        'color' => "hijau-color"
                    ],
                    'Lalat Buah' => [
                        'suhu' => ['min' => 12, 'max' => 35, 'opt_min' => 20, 'opt_max' => 28],
                        'kelembaban' => ['min' => 60, 'max' => 90, 'opt_min' => 70, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 2000, 'opt_min' => 1000, 'opt_max' => 1500],
                        'color' => "oren-color"
                    ],
                ],
                'padi' => [
                    'Wereng' => [
                        'suhu' => ['min' => 15, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 60, 'max' => 90, 'opt_min' => 60, 'opt_max' => 90],
                        'curah_hujan' => ['min' => 500, 'max' => 2500, 'opt_min' => 1200, 'opt_max' => 2000],
                        'color' => "merah-color"
                    ],
                    'Penggerek batang padi' => [
                        'suhu' => ['min' => 15, 'max' => 37, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 60, 'max' => 95, 'opt_min' => 70, 'opt_max' => 95],
                        'curah_hujan' => ['min' => 800, 'max' => 2000, 'opt_min' => 1200, 'opt_max' => 1800],
                        'color' => "hijau-color"
                    ],
                    'Walang sangit' => [
                        'suhu' => ['min' => 18, 'max' => 35, 'opt_min' => 28, 'opt_max' => 32],
                        'kelembaban' => ['min' => 50, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 2000, 'opt_min' => 1000, 'opt_max' => 2000],
                        'color' => "oren-color"
                    ],
                ],
                'bawang-merah' => [
                    'Thrips' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 500, 'max' => 1500, 'opt_min' => 1200, 'opt_max' => 1500],
                        'color' => "merah-color"
                    ],
                    'Ulat Bawang Merah' => [
                        'suhu' => ['min' => 13, 'max' => 35, 'opt_min' => 25, 'opt_max' => 30],
                        'kelembaban' => ['min' => 40, 'max' => 90, 'opt_min' => 60, 'opt_max' => 80],
                        'curah_hujan' => ['min' => 600, 'max' => 1800, 'opt_min' => 1000, 'opt_max' => 1800],
                        'color' => "hijau-color"
                    ],
                    'Moler' => [
                        'suhu' => ['min' => 10, 'max' => 35, 'opt_min' => 20, 'opt_max' => 28],
                        'kelembaban' => ['min' => 60, 'max' => 95, 'opt_min' => 80, 'opt_max' => 90],
                        'curah_hujan' => ['min' => 800, 'max' => 2000, 'opt_min' => 1200, 'opt_max' => 1800],
                        'color' => "oren-color"
                    ],
                ],
            ];


            if ($jumlahHari > 0) {
                $rataCuaca = [
                    'suhu' => [
                        'min' => round($totalSuhuMin / $jumlahHari, 1),
                        'max' => round($totalSuhuMax / $jumlahHari, 1),
                        'optimum' => round($totalSuhuOptimum / $jumlahHari, 1),
                    ],
                    'kelembapan' => [
                        'min' => isset($totalKelembapanMin) ? round($totalKelembapanMin / $jumlahHari, 1) : 0,
                        'max' => isset($totalKelembapanMax) ? round($totalKelembapanMax / $jumlahHari, 1) : 0,
                        'optimum' => isset($totalKelembapanOptimum) ? round($totalKelembapanOptimum / $jumlahHari, 1) : 0,
                    ],
                    'curah_hujan' => [
                        'min' => round($curahHujanMin, 1) * 70,
                        'max' => round($curahHujanMax, 1) * 70,
                        'optimum' => round($curahHujanOptimum, 1) * 70,
                    ],
                ];


                $hamaTerdekat = [];
                $skorTertinggi = [];
                $colorTertinggi = [];

                foreach ($hama_kriteria as $tanaman => $hamaList) {
                    $hamaTerdekat[$tanaman] = null;
                    $skorTertinggi[$tanaman] = 0;

                    foreach ($hamaList as $namaHama => $kriteria) {
                        $skor = 0;

                        // Cek suhu
                        if ($rataCuaca['suhu']['optimum'] >= $kriteria['suhu']['opt_min'] && $rataCuaca['suhu']['optimum'] <= $kriteria['suhu']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['suhu']['optimum'] >= $kriteria['suhu']['min'] && $rataCuaca['suhu']['optimum'] <= $kriteria['suhu']['max']) {
                            $skor += 1;
                        }

                        // Cek kelembapan
                        if ($rataCuaca['kelembapan']['optimum'] >= $kriteria['kelembaban']['opt_min'] && $rataCuaca['kelembapan']['optimum'] <= $kriteria['kelembaban']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['kelembapan']['optimum'] >= $kriteria['kelembaban']['min'] && $rataCuaca['kelembapan']['optimum'] <= $kriteria['kelembaban']['max']) {
                            $skor += 1;
                        }

                        // Cek curah hujan
                        if ($rataCuaca['curah_hujan']['optimum'] >= $kriteria['curah_hujan']['opt_min'] && $rataCuaca['curah_hujan']['optimum'] <= $kriteria['curah_hujan']['opt_max']) {
                            $skor += 2;
                        } elseif ($rataCuaca['curah_hujan']['optimum'] >= $kriteria['curah_hujan']['min'] && $rataCuaca['curah_hujan']['optimum'] <= $kriteria['curah_hujan']['max']) {
                            $skor += 1;
                        }

                        // Simpan hama dengan skor tertinggi per tanaman
                        if ($skor > $skorTertinggi[$tanaman]) {
                            $skorTertinggi[$tanaman] = $skor;
                            $hamaTerdekat[$tanaman] = $namaHama;
                            $colorTerdekat[$tanaman] = $kriteria['color'];
                        }
                    }
                }

                $weatherData[] = [
                    'kecamatan' => $namaKecamatan,
                    'rata_rata' => [
                        'suhu' => [
                            'min' => $rataCuaca['suhu']['min'] . "°C",
                            'max' => $rataCuaca['suhu']['max'] . "°C",
                            'optimum' => $rataCuaca['suhu']['optimum'] . "°C",
                        ],
                        'kelembapan' => [
                            'min' => $rataCuaca['kelembapan']['min'] . "%",
                            'max' => $rataCuaca['kelembapan']['max'] . "%",
                            'optimum' => $rataCuaca['kelembapan']['optimum'] . "%",
                        ],
                        'curah_hujan' => [
                            'min' => $rataCuaca['curah_hujan']['min'] . " mm",
                            'max' => $rataCuaca['curah_hujan']['max'] . " mm",
                            'optimum' => $rataCuaca['curah_hujan']['optimum'] . " mm",
                        ],
                        'hama' => $hamaTerdekat, // Hasil akhir berupa array per tanaman
                        'color' => $colorTerdekat, // Hasil akhir berupa array per tanaman
                    ],
                ];
            }
        }


        // Menghitung hari Senin berikutnya
        $firstMonday = Carbon::now('UTC')->next(Carbon::MONDAY); // Senin pertama setelah hari ini
        $secondMonday = $firstMonday->copy()->addWeeks(1); // Senin kedua setelah 2 minggu

        // Format tanggal untuk hari Senin berikutnya
        $secondMondayFormatted = $secondMonday->format('Y-m-d');

        return ['weatherData' => $weatherData, 'kota' => $kota, 'kecamatanBrebes' => $kecamatanBrebes, 'nextMonday' => $secondMondayFormatted];
    }
}


if (!function_exists('datakecamatan')) {
    function datakecamatan($kecamatan, $dataCuaca)
    {
        // Ambil data berdasarkan kecamatan
        $kecamatanDicari = $kecamatan;
        $hasil = array_filter($dataCuaca, function ($item) use ($kecamatanDicari) {
            return $item['kecamatan'] === $kecamatanDicari;
        });

        // Reset array index
        return array_values($hasil);
    }
}
