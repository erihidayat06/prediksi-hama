<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gap;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command
{
    // Nama perintah yang akan diketik di terminal
    protected $signature = 'image:convert-webp';
    protected $description = 'Konversi semua gambar lama di tabel GAP ke format WebP';

    public function handle()
    {
        $manager = new ImageManager(new Driver());
        $gaps = Gap::all();
        $count = 0;

        $this->info('Memulai konversi...');

        foreach ($gaps as $gap) {
            if ($gap->gambar && !str_contains($gap->gambar, '.webp')) {
                // Ambil path relatif (hapus /storage/ jika ada)
                $oldRelativePath = str_replace('/storage/', '', $gap->gambar);

                if (Storage::disk('public')->exists($oldRelativePath)) {
                    try {
                        // 1. Baca Gambar
                        $image = $manager->read(Storage::disk('public')->path($oldRelativePath));

                        // 2. Tentukan nama baru
                        $pathInfo = pathinfo($oldRelativePath);
                        $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

                        // 3. Simpan sebagai WebP
                       // 3. Simpan sebagai WebP
                        $encoded = $image->toWebp(75); // Intervention v3: quality langsung sebagai argumen pertama

                        // Gunakan ->toString() agar benar-benar menjadi data biner string
                        Storage::disk('public')->put($newPath, $encoded->toString());

                        // 4. Update Database
                        $gap->update(['gambar' => Storage::url($newPath)]);

                        // 5. Hapus file lama jika nama filenya berbeda
                        if ($oldRelativePath !== $newPath) {
                            Storage::disk('public')->delete($oldRelativePath);
                        }

                        $count++;
                        $this->line("Berhasil: {$oldRelativePath} -> WebP");
                    } catch (\Exception $e) {
                        $this->error("Gagal memproses {$oldRelativePath}: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info("Selesai! {$count} gambar telah dikonversi.");
    }
}
