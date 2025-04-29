<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HargaTanaman;
use App\Models\Komoditi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FetchHargaPangan extends Command
{
    protected $signature = 'fetch:harga-pangan';
    protected $description = 'Ambil data harga pangan terbaru dari API dan simpan ke database';

    public function handle()
    {
        // Mapping variant_id ke tanaman_id
        $tanamanMap = [
            52 => 1, // Padi
            9  => 2, // Cabai
            13 => 3  // Bawang Merah
        ];

        // Ambil tanggal terbaru dari database
        $latestDate = Komoditi::max('tanggal');

        if (!$latestDate) {
            $this->error("Database kosong, harap tambahkan data awal.");
            return;
        }

        $startDate = Carbon::parse($latestDate)->addDay(); // mulai dari hari setelah latest
        $endDate = Carbon::today(); // hingga hari ini

        while ($startDate->lte($endDate)) {
            $tanggal = $startDate->format('Y-m-d');
            $this->info("Memproses tanggal: $tanggal");

            foreach ($tanamanMap as $variant_id => $tanaman_id) {
                $url = "https://api-sp2kp.kemendag.go.id/report/api/average-price-public?level=1&tanggal=$tanggal&take=9999999&variant_id=$variant_id";

                try {
                    $response = Http::timeout(10)->get($url);

                    if (!$response->ok()) {
                        $this->warn("Gagal mengambil data untuk variant_id $variant_id. Status: " . $response->status());
                        continue;
                    }

                    $data = $response->json()['data'] ?? [];

                    if (empty($data)) {
                        $this->warn("Tidak ada data untuk variant_id $variant_id pada tanggal $tanggal.");
                        continue;
                    }

                    foreach ($data as $item) {
                        if ($item['nama_provinsi'] === 'Jawa Tengah') {
                            Komoditi::updateOrCreate(
                                [
                                    'nama_provinsi' => $item['nama_provinsi'],
                                    'tanaman_id'    => $tanaman_id,
                                    'tanggal'       => $tanggal,
                                ],
                                [
                                    'harga_provinsi' => $item['harga']
                                ]
                            );
                        }
                    }

                    $this->info("Data untuk variant_id $variant_id berhasil diproses pada tanggal $tanggal.");
                } catch (\Exception $e) {
                    $this->error("Error saat mengakses API untuk variant_id $variant_id pada tanggal $tanggal: " . $e->getMessage());
                }
            }

            $startDate->addDay(); // Lanjut ke hari berikutnya
        }

        $this->info("Proses fetch harga pangan selesai hingga tanggal " . Carbon::today()->format('Y-m-d') . ".");
    }
}
