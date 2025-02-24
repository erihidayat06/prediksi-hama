<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarketController extends Controller
{
    public function showProducts()
    {
        // Data produk statis
        $products = [
            ['name' => 'Cabai (Chili)', 'description' => 'Obat pertanian untuk tanaman cabai.', 'price' => 50000],
            ['name' => 'Padi (Rice)', 'description' => 'Obat pertanian untuk tanaman padi.', 'price' => 75000],
            ['name' => 'Tomat (Tomato)', 'description' => 'Obat fungisida untuk tanaman tomat.', 'price' => 60000],
            ['name' => 'Sayuran (Vegetables)', 'description' => 'Obat pembasmi hama untuk tanaman sayuran.', 'price' => 65000],
            ['name' => 'Jagung (Corn)', 'description' => 'Obat untuk mengatasi hama pada tanaman jagung.', 'price' => 55000],
            ['name' => 'Kentang (Potato)', 'description' => 'Obat penghilang jamur pada tanaman kentang.', 'price' => 70000],
            ['name' => 'Wortel (Carrot)', 'description' => 'Pestisida untuk tanaman wortel.', 'price' => 45000],
            ['name' => 'Kacang (Peanuts)', 'description' => 'Fertilisasi organik untuk tanaman kacang.', 'price' => 80000],
            ['name' => 'Bawang Merah (Shallots)', 'description' => 'Obat pengendali hama untuk tanaman bawang merah.', 'price' => 60000],
            ['name' => 'Bawang Putih (Garlic)', 'description' => 'Obat anti-virus untuk tanaman bawang putih.', 'price' => 75000],
        ];


        // Mendapatkan gambar dari Unsplash berdasarkan nama produk
        foreach ($products as &$product) {
            $product['image_url'] = $this->getImageFromLoremPicsum($product['name']);
        }

        return view('products.index', compact('products'));
    }

    private function getImageFromLoremPicsum($query)
    {
        // Lorem Picsum menyediakan gambar acak berdasarkan kategori atau ukuran
        $url = "https://picsum.photos/seed/{$query}/500/500"; // Gambar acak dengan ukuran 500x500

        return $url;
    }
}
