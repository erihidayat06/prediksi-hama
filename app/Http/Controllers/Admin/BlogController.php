<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blog.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $gambar = $request->file('gambar')->store('hama_images', 'public');
        $gambarUrl = Storage::url($gambar);
        $slug = Str::slug($request->judul) . '-' . now()->format('His');

        Blog::create([
            'gambar' => $gambarUrl,
            'judul' => $request->judul,
            'slug' => $slug,
            'isi' => $request->isi,
        ]);

        return redirect()->route('blog.index')->with('success', 'blog berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {

        return view('admin.blog.edit', ['blog' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        // Validasi inputan
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048', // Validasi gambar
            'judul' => 'required|string|max:255', // Validasi judul
            'isi' => 'required|string', // Validasi isi
        ]);

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($blog->gambar) {
                $imagePath = str_replace('/storage/', '', $blog->gambar); // Menyesuaikan path gambar
                Storage::delete($imagePath);
            }

            // Simpan gambar baru
            $gambar = $request->file('gambar')->store('public/blog'); // Menyimpan gambar di folder 'public/blog'
            $blog->gambar = Storage::url($gambar); // Mengupdate URL gambar
        }
        $slug = Str::slug($request->judul) . '-' . now()->format('His');

        // Mengupdate data blog
        $blog->judul = $request->judul;
        $blog->slug = $slug;
        $blog->isi = $request->isi;
        $blog->save();

        // Redirect ke halaman daftar dengan pesan sukses
        return redirect()->route('blog.index')->with('success', 'Blog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Mengecek apakah ada gambar yang ter-upload dan menghapusnya
        if ($blog->gambar) {
            $imagePath = str_replace('/storage/', '', $blog->gambar); // Menyesuaikan path gambar
            Storage::delete($imagePath);
        }

        // Menghapus data blog dari database
        $blog->delete();

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('blog.index')->with('success', 'Blog berhasil dihapus');
    }
}
