<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gap;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tanaman $tanaman)
    {
        $gaps = $tanaman->gaps;
        return view('admin.gap.index', ['gaps' => $gaps, 'tanaman' => $tanaman]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tanaman $tanaman)
    {
        return view('admin.gap.create', ['tanaman' => $tanaman]);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request, Tanaman $tanaman)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'usia' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'tanaman_id' => 'required|exists:tanamans,id'
        ], [
            'gambar.required' => 'Gambar wajib diunggah.',
            'usia.required' => 'Usia wajib diisi.',
            'kegiatan.required' => 'Kegiatan wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ]);

        $gambarUrl = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // 1. Inisialisasi Image Manager
            $manager = new ImageManager(new Driver());

            // 2. Baca gambar
            $image = $manager->read($file);

            // 3. Resize (Opsional)
            $image->scale(width: 1000);

            // 4. Siapkan nama file dengan ekstensi .webp
            $fileName = time() . '_' . uniqid() . '.webp';
            $path = 'gap/' . $fileName;

            // 5. ENCODE KE WEBP & KOMPRES (Quality 70-80 sudah sangat bagus)
            $encoded = $image->toWebp(quality: 75);

            // Simpan ke storage
            Storage::disk('public')->put($path, (string) $encoded);

            $gambarUrl = Storage::url($path);
        }

        Gap::create([
            'gambar' => $gambarUrl,
            'usia' => $request->usia,
            'kegiatan' => $request->kegiatan,
            'keterangan' => $request->keterangan,
            'tanaman_id' => $request->tanaman_id,
        ]);

        return redirect()
            ->route('gap.index', ['tanaman' => $tanaman->nm_tanaman])
            ->with('success', 'Kegiatan berhasil ditambahkan dengan format WebP!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Gap $gap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanaman $tanaman, Gap $gap)
    {
        return view('admin.gap.edit', ['tanaman' => $tanaman, 'gap' => $gap]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanaman $tanaman, Gap $gap)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'usia' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'keterangan' => 'required|string'
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'usia.required' => 'Usia wajib diisi.',
            'kegiatan.required' => 'Kegiatan wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.'
        ]);

        if ($request->hasFile('gambar')) {
            // 1. Hapus gambar lama jika ada
            if ($gap->gambar) {
                // Mengubah URL (/storage/gap/abc.webp) menjadi path (gap/abc.webp)
                $oldPath = str_replace('/storage/', '', $gap->gambar);
                Storage::disk('public')->delete($oldPath);
            }

            // 2. Proses gambar baru dengan ImageManager
            $file = $request->file('gambar');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);

            // Resize & Konversi ke WebP
            $image->scale(width: 1000);
            $fileName = time() . '_' . uniqid() . '.webp';
            $path = 'gap/' . $fileName;

            // Simpan ke Storage
            $encoded = $image->toWebp(quality: 75);
            Storage::disk('public')->put($path, (string) $encoded);

            // Update URL di database
            $gap->gambar = Storage::url($path);
        }

        // 3. Update data lainnya
        $gap->update([
            'usia' => $request->usia,
            'kegiatan' => $request->kegiatan,
            'keterangan' => $request->keterangan,
            'gambar' => $gap->gambar, // Pastikan field gambar ikut terupdate jika ada perubahan
        ]);

        return redirect()
            ->route('gap.index', ['tanaman' => $tanaman->nm_tanaman])
            ->with('success', 'Kegiatan berhasil diperbarui ke format WebP!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gap $gap)
    {


        // Hapus gambar jika ada
        if ($gap->gambar && file_exists(public_path($gap->gambar))) {
            unlink(public_path($gap->gambar));
        }

        $gap->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
