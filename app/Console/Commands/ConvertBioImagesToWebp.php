<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bio; // Pastikan model Bio sudah di-import
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertBioImagesToWebp extends Command
{
    protected $signature = 'image:convert-bio-webp';
    protected $description = 'Konversi semua gambar di tabel BIO ke format WebP';

    public function handle()
    {
        $manager = new ImageManager(new Driver());
        // Menggunakan chunk agar tidak berat jika data Bio sangat banyak
        $bios = Bio::whereNotNull('gambar')
                   ->where('gambar', 'NOT LIKE', '%.webp')
                   ->get();

        $count = 0;
        $this->info('Memulai konversi untuk tabel Bio...');

        foreach ($bios as $bio) {
            // Ambil path relatif (hapus /storage/ atau URL domain jika ada)
            $oldRelativePath = str_replace(['/storage/', Storage::url('')], '', $bio->gambar);

            if (Storage::disk('public')->exists($oldRelativePath)) {
                try {
                    // 1. Baca Gambar
                    $image = $manager->read(Storage::disk('public')->path($oldRelativePath));

                    // 2. Tentukan nama baru
                    $pathInfo = pathinfo($oldRelativePath);
                    $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

                    // 3. Simpan sebagai WebP (Intervention v3)
                    $encoded = $image->toWebp(75);
                    Storage::disk('public')->put($newPath, $encoded->toString());

                    // 4. Update Database
                    $bio->update(['gambar' => Storage::url($newPath)]);

                    // 5. Hapus file lama jika formatnya bukan webp
                    if ($oldRelativePath !== $newPath) {
                        Storage::disk('public')->delete($oldRelativePath);
                    }

                    $count++;
                    $this->line("Berhasil (Bio): {$oldRelativePath} -> WebP");
                } catch (\Exception $e) {
                    $this->error("Gagal memproses Bio {$oldRelativePath}: " . $e->getMessage());
                }
            }
        }

        $this->info("Selesai! {$count} gambar Bio telah dikonversi.");
    }
}
