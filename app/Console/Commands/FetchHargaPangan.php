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

        // **Langkah 1: Ambil tanggal terbaru dari database**
        $latestDate = Komoditi::max('tanggal');

        if (!$latestDate) {
            $this->error("Database kosong, harap tambahkan data awal.");
            return;
        }

        // **Langkah 2: Tambah 1 hari dari tanggal terbaru**
        $nextDate = Carbon::parse($latestDate)->addDay()->format('Y-m-d');

        foreach ($tanamanMap as $variant_id => $tanaman_id) {
            $url = "https://api-sp2kp.kemendag.go.id/report/api/average-price-public?level=1&tanggal=$nextDate&take=9999999&variant_id=$variant_id";

            $response = Http::get($url);
            $data = $response->json()['data'] ?? [];

            foreach ($data as $item) {
                if ($item['nama_provinsi'] === 'Jawa Tengah') {
                    // **Simpan hanya jika tanggal ini belum ada di database**
                    Komoditi::updateOrCreate(
                        [
                            'nama_provinsi' => $item['nama_provinsi'],
                            'tanaman_id'    => $tanaman_id,
                            'tanggal'       => $nextDate,
                        ],
                        [
                            'harga_provinsi' => $item['harga']
                        ]
                    );
                }
            }
        }

        $this->info("Data harga pangan untuk tanggal $nextDate berhasil ditambahkan!");
    }
}
