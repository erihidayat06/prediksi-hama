<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    public function index()
    {

        $produk = Produk::aktif()->get();

        return view('home.marketplace.index', ['produk' => $produk]);
    }


    public function cari(Request $request)
    {
        $query = $request->input('q');

        $produk = Produk::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->orWhere('kecamatan', 'like', '%' . $query . '%')
            ->orWhere('desa', 'like', '%' . $query . '%')
            ->orWhere('alamat', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(12);

        return view('home.marketplace.index', compact('produk', 'query'));
    }



    public function showProducts(Produk $produk)
    {

        return view('home.marketplace.show', ['produk' => $produk]);
    }
    public function jualProducts()
    {

        return view('home.marketplace.jual');
    }

    public function store(Request $request)
    {

        // Validasi Input
        $request->validate([
            'gambar'    => 'min:1|max:5', // Maksimal 5 gambar
            'gambar.*'  => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Maks 10MB per gambar
            'judul'     => 'required|string|max:255',
            'no_tlp'    => 'required|string|max:20',
            'harga'     => 'required|string|max:50',
            'satuan'    => 'required|string|max:50',
            'kecamatan' => 'required|string|max:100',
            'desa'      => 'required|string|max:100',
            'alamat'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Ambil ID user yang sedang login
        $user_id = auth()->id();

        // Pastikan folder storage bisa diakses
        if (!is_dir(storage_path('app/public/uploads'))) {
            mkdir(storage_path('app/public/uploads'), 0777, true);
        }

        // Simpan semua gambar
        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                if ($gambar->isValid()) {
                    $gambarPaths[] = $gambar->store('uploads', 'public');
                }
            }
        }

        // Buat slug unik
        $slug = Str::slug($request->judul) . date('His');
        $slugCount = Produk::where('slug', 'LIKE', "$slug%")->count();
        if ($slugCount > 0) {
            $slug .= '-' . ($slugCount + 1);
        }

        // Simpan data ke database
        Produk::create([
            'judul'     => $request->judul,
            'slug'      => $slug, // Simpan slug
            'no_tlp'    => $request->no_tlp,
            'harga'     => $request->harga,
            'satuan'    => $request->satuan,
            'kecamatan' => $request->kecamatan,
            'desa'      => $request->desa,
            'alamat'    => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'gambar'    => json_encode($gambarPaths), // Simpan sebagai JSON
            'user_id'   => $user_id, // Simpan user ID yang sedang login
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }


    public function add(Request $request, $id)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(["message" => "Anda harus login untuk menambahkan ke keranjang!"], 401);
        }

        $user_id = Auth::id(); // Ambil user yang sedang login
        $produk = Produk::findOrFail($id);

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $user_id)->where('produk_id', $id)->first();

        if ($cartItem) {
            $cartItem->quantity += 1; // Jika sudah ada, tambahkan quantity
            $cartItem->save();
        } else {
            // Jika belum ada, buat item baru di cart
            Cart::create([
                'user_id' => $user_id,
                'produk_id' => $id,
                'quantity' => 1,
            ]);
        }

        // Ambil semua data cart untuk user yang sedang login
        $cart = Cart::where('user_id', $user_id)->with('produk')->get();

        return response()->json([
            "message" => "Produk berhasil ditambahkan ke keranjang!",
            "cart" => $cart
        ]);
    }

    public function checkCart($id)
    {
        $exists = DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('produk_id', $id)
            ->exists();

        return response()->json(['exists' => $exists]);
    }


    public function getCartData()
    {
        $cart = DB::table('carts')
            ->join('produks', 'carts.produk_id', '=', 'produks.id') // Pastikan tabel sesuai
            ->where('carts.user_id', Auth::id()) // Tambahkan prefix 'carts.'
            ->select(
                'carts.id',
                'produks.judul',
                'produks.slug',
                'produks.gambar',
                'carts.quantity',
                'produks.harga'
            )
            ->get();

        return response()->json($cart);
    }

    public function remove($id)
    {
        $userId = Auth::id();

        // Cek apakah item keranjang benar-benar milik user yang login
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->first();

        if (!$cartItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found or unauthorized',
            ], 404);
        }

        // Hapus item
        $cartItem->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart',
        ]);
    }





    public function Products()
    {
        $produks = auth()->user()->produk;
        return view('home.marketplace.produk', ['produks' => $produks]);
    }
    public function edit(Produk $produk)
    {
        return view('home.marketplace.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'no_tlp' => 'nullable|string|max:20',
            'harga' => 'required|numeric',
            'satuan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048', // tiap file max 2MB
        ]);

        // Simpan data form kecuali gambar
        $produk->judul = $request->judul;
        $produk->no_tlp = $request->no_tlp;
        $produk->harga = $request->harga;
        $produk->satuan = $request->satuan;
        $produk->kecamatan = $request->kecamatan;
        $produk->desa = $request->desa;
        $produk->alamat = $request->alamat;
        $produk->deskripsi = $request->deskripsi;

        // Ambil gambar lama dari database
        $gambarLama = json_decode($produk->gambar, true) ?? [];

        // Cek apakah ada gambar yang dihapus
        $hapusGambar = $request->input('hapus_gambar', []);

        if (!empty($hapusGambar)) {
            foreach ($hapusGambar as $gambar) {
                // Hapus dari storage
                Storage::disk('public')->delete($gambar);

                // Hapus dari array gambarLama
                $gambarLama = array_filter($gambarLama, function ($item) use ($gambar) {
                    return $item !== $gambar;
                });
            }
        }

        // Gambar baru (jika ada)
        $gambarBaru = [];

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                $path = $image->store('produk', 'public');
                $gambarBaru[] = $path;
            }
        }

        // Gabungkan semua (gambar lama yang tersisa + baru), maksimal 5
        $semuaGambar = array_slice(array_merge($gambarLama, $gambarBaru), 0, 5);
        $produk->gambar = json_encode(array_values($semuaGambar));

        $produk->save();

        return redirect()->route('produk.saya')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        // Hapus semua gambar dari storage
        $gambar = json_decode($produk->gambar, true) ?? [];
        foreach ($gambar as $path) {
            Storage::disk('public')->delete($path);
        }

        $produk->delete();

        return redirect()->route('produk.saya')->with('success', 'Produk berhasil dihapus.');
    }




    public function toggleStatus($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->aktive = !$produk->aktive;
        $produk->save();

        return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
    }


    private function getImageFromLoremPicsum($query)
    {
        // Lorem Picsum menyediakan gambar acak berdasarkan kategori atau ukuran
        $url = "https://picsum.photos/seed/{$query}/500/500"; // Gambar acak dengan ukuran 500x500

        return $url;
    }
}
