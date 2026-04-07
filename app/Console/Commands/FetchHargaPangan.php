<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Komoditi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FetchHargaPangan extends Command
{
    protected $signature = 'fetch:harga-pangan';
    protected $description = 'Ambil data harga pangan terbaru dari API HNT Kemendag';

    public function handle()
    {
        // Mapping variant_id ke tanaman_id
        $tanamanMap = [
            52 => 1, // Padi
            9  => 2, // Cabai
            13 => 3  // Bawang Merah
        ];

        // Ambil tanggal terakhir di DB untuk menentukan Start Date
        $latestDate = Komoditi::max('tanggal');

        // Jika DB kosong, tarik dari 30 hari yang lalu
        $startDate = $latestDate ? Carbon::parse($latestDate)->addDay()->format('Y-m-d') : Carbon::today()->subDays(30)->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');

        if ($startDate > $endDate) {
            $this->info("Data sudah up-to-date sampai tanggal $latestDate.");
            return;
        }

        $this->info("Menarik data dari $startDate sampai $endDate...");

        foreach ($tanamanMap as $variant_id => $tanaman_id) {
            $url = "https://api-sp2kp.kemendag.go.id/report/api/hnt/history-series";

            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Referer' => 'https://sp2kp.kemendag.go.id/',
                ])->get($url, [
                    'tanggal_start' => $startDate,
                    'tanggal_end'   => $endDate,
                    'variant_id'    => $variant_id
                ]);

                $apiData = $response->json()['data'] ?? [];

                // DEBUG: Cek satu data pertama di terminal
                if (!empty($apiData)) {
                    $sample = collect($apiData)->first();
                    $this->info("Contoh data variant $variant_id: " . json_encode($sample));
                }

                foreach ($apiData as $key => $item) {
                    // 1. Ambil tanggal & harga dengan lebih teliti
                    $tglRaw = $item['tanggal_data'] ?? $item['tgl'] ?? $item['x'] ?? (is_string($key) ? $key : null);
                    $hargaRaw = $item['harga'] ?? $item['harga_rata_rata'] ?? $item['y'] ?? 0;

                    if (!$tglRaw) continue;

                    // 2. Pakai format Y-m-d H:i:s karena kolommu TIMESTAMP
                    $tglFix = Carbon::parse($tglRaw)->startOfDay()->format('Y-m-d H:i:s');
                    $hargaFix = (int) preg_replace('/[^0-9]/', '', (string)$hargaRaw);

                    if ($hargaFix <= 0) continue;

                    // 3. Eksekusi simpan
                    $this->info("Menyimpan: $tglFix | Harga: $hargaFix"); // Cek di terminal muncul gak?

                    Komoditi::updateOrCreate(
                        [
                            // PENTING: Gunakan kolom yang unik untuk pengecekan
                            'tanggal'       => $tglFix,
                            'tanaman_id'    => $tanaman_id,
                            'nama_provinsi' => 'Jawa Tengah',
                        ],
                        [
                            'harga_provinsi' => $hargaFix,
                            // Pakai updated_at manual agar tidak bentrok dengan trigger MySQL
                            'updated_at'     => now()
                        ]
                    );
                }
                $this->info("Berhasil update variant $variant_id");
            } catch (\Exception $e) {
                $this->error("Gagal di variant $variant_id: " . $e->getMessage());
            }
        }

        $this->info("Selesai!");
    }
}
