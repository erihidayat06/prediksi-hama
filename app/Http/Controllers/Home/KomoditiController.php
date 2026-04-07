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
        $tanamanMap = [52 => 1, 9 => 2, 13 => 3];
        $variants = array_keys($tanamanMap);

        $endDate = Carbon::today()->subDays(2)->format('Y-m-d');
        $startDate = Carbon::parse($endDate)->subDays(32)->format('Y-m-d');

        $result = [];
        $raw_debug = []; // Untuk intip isi asli API

        foreach ($variants as $variant_id) {
            // Gunakan parameter yang lebih lengkap sesuai kebutuhan API SP2KP
            $url = "https://api-sp2kp.kemendag.go.id/report/api/hnt/history-series";

            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Referer' => 'https://sp2kp.kemendag.go.id/',
                    'Accept' => 'application/json',
                ])->timeout(20)->get($url, [
                    'tanggal_start' => $startDate,
                    'tanggal_end'   => $endDate,
                    'variant_id'    => $variant_id
                ]);

                $body = $response->json();
                $raw_debug[$variant_id] = $body; // Simpan respon mentah

                if ($response->ok() && isset($body['data'])) {
                    $apiData = $body['data'];

                    foreach ($apiData as $key => $item) {
                        // dd($apiData);
                        // DETEKSI TANGGAL: API series seringkali menggunakan tanggal sebagai KEY
                        // atau dalam properti 'x' / 'tanggal'
                        $tglRaw = $item['tanggal_data'] ?? $item['tgl'] ?? $item['x'] ?? (is_string($key) ? $key : null);

                        // DETEKSI HARGA: seringkali di properti 'y' atau 'harga'
                        $hargaRaw = $item['harga'] ?? $item['harga_rata_rata'] ?? $item['y'] ?? null;

                        if (!$tglRaw || $hargaRaw === null) continue;

                        $tglFix = Carbon::parse($tglRaw)->startOfDay()->toDateTimeString();
                        $hargaFix = (int) preg_replace('/[^0-9]/', '', (string)$hargaRaw);

                        // Eksekusi Database
                        \App\Models\Komoditi::updateOrCreate(
                            [
                                'tanggal'       => $tglFix,
                                'tanaman_id'    => $tanamanMap[$variant_id],
                                'nama_provinsi' => 'Jawa Tengah',
                            ],
                            ['harga_provinsi' => $hargaFix]
                        );

                        $result[] = [
                            'variant_id' => $variant_id,
                            'tanggal'    => $tglFix,
                            'harga'      => $hargaFix
                        ];
                    }
                }
            } catch (\Exception $e) {
                $raw_debug['errors'][] = $e->getMessage();
            }
        }

        // Jika $result kosong, kita tampilkan $raw_debug untuk tahu isi asli API
        return response()->json([
            'is_empty' => empty($result),
            'debug_api_response' => $raw_debug,
            'processed_data' => $result
        ]);
    }
}
