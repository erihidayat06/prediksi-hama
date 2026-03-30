<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Dr
use Illuminate\Support\Str;

class BioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tanaman $tanaman)
    {

        $bios = $tanaman->bio;
        return view('admin.bios.index', ['bios' => $bios, 'tanaman' => $tanaman]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tanaman $tanaman)
    {
        return view('admin.bios.create', ['tanaman' => $tanaman]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tanaman $tanaman)
    {
        $request->validate([
            'sebaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nm_hama' => 'required|string|max:255',
            'order' => 'required|string|max:255',
            'suborder' => 'nullable|string|max:255',
            'families' => 'required|string|max:255',
            'genus' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        // Inisialisasi Image Manager (v3)
        $manager = new ImageManager(new Driver());

        // Fungsi helper untuk proses compress & convert ke WebP
        $processImage = function($file) use ($manager) {
            $filename = Str::random(20) . '.webp';
            $path = 'hama_images/' . $filename;

            // Gunakan variabel $file (argumen fungsi), BUKAN $request->file('gambar')
            $encoded = $manager->read($file)->toWebp(80);

            // Simpan ke storage public
            Storage::disk('public')->put($path, (string) $encoded);

            // Kembalikan path untuk disimpan di database
            return Storage::url($path);
        };

        // Proses masing-masing file
        $gambarPath = $request->hasFile('gambar') ? $processImage($request->file('gambar')) : null;
        $sebaranPath = $request->hasFile('sebaran') ? $processImage($request->file('sebaran')) : null;

        Bio::create([
            'gambar' => $gambarPath,
            'sebaran' => $sebaranPath,
            'nm_hama' => $request->nm_hama,
            'order' => $request->order,
            'suborder' => $request->suborder,
            'families' => $request->families,
            'genus' => $request->genus,
            'species' => $request->species,
            'deskripsi' => $request->deskripsi,
            'tanaman_id' => $tanaman->id,
        ]);

        return redirect()->route('bio.index', ['tanaman' => $tanaman->nm_tanaman])
                        ->with('success', 'Data berhasil ditambahkan dalam format WebP.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bio $bio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanaman $tanaman, Bio $bio)
    {
        return view('admin.bios.edit', ['bio' => $bio, 'tanaman' => $tanaman]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanaman $tanaman, Bio $bio)
    {
        $messages = [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'nm_hama.required' => 'Nama hama wajib diisi.',
            'order.required' => 'Order wajib diisi.',
            'suborder.required' => 'Suborder wajib diisi.',
            'families.required' => 'Families wajib diisi.',
            'genus.required' => 'Genus wajib diisi.',
            'species.required' => 'Species wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
        ];

        $validatedData = $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sebaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nm_hama' => 'required|string|max:255',
            'order' => 'required|string|max:255',
            'suborder' => 'required|string|max:255',
            'families' => 'required|string|max:255',
            'genus' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ], $messages);

       $manager = new ImageManager(new Driver());

        // Helper untuk hapus file lama & upload baru (WebP)
        $updateImage = function($file, $oldPath) use ($manager) {
            // 1. Hapus file lama jika ada
            if ($oldPath) {
                $relativeOldPath = str_replace('/storage/', '', $oldPath);
                if (Storage::disk('public')->exists($relativeOldPath)) {
                    Storage::disk('public')->delete($relativeOldPath);
                }
            }

            // 2. Proses file baru ke WebP
            $filename = Str::random(20) . '.webp';
            $newPath = 'hama_images/' . $filename;
            $encoded = $manager->read($file)->toWebp(80);

            Storage::disk('public')->put($newPath, (string) $encoded);

            return Storage::url($newPath);
        };

        // Update data text secara massal
        $bio->fill($request->only([
            'nm_hama', 'order', 'suborder', 'families', 'genus', 'species', 'deskripsi'
        ]));

        // Cek jika ada upload file baru
        if ($request->hasFile('gambar')) {
            $bio->gambar = $updateImage($request->file('gambar'), $bio->gambar);
        }

        if ($request->hasFile('sebaran')) {
            $bio->sebaran = $updateImage($request->file('sebaran'), $bio->sebaran);
        }

        $bio->save();

        return redirect()->route('bio.index', $tanaman->nm_tanaman)
            ->with('success', 'Data dan gambar berhasil diperbarui ke format WebP!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bio $bio)
    {
        // Hapus gambar jika ada
        if ($bio->gambar) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $bio->gambar));
        }

        // Hapus data dari database
        $bio->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
