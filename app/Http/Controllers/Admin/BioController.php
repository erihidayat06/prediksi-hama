<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('hama_images', 'public');
            $gambarUrl = Storage::url($gambarPath);
        }
        if ($request->hasFile('sebaran')) {
            $sebaranPath = $request->file('sebaran')->store('hama_images', 'public');
            $sebaranUrl = Storage::url($sebaranPath);
        }

        $hama = Bio::create([
            'gambar' => $gambarUrl ?? null,
            'gambar' => $sebaranUrl ?? null,
            'nm_hama' => $request->nm_hama,
            'order' => $request->order,
            'suborder' => $request->suborder,
            'families' => $request->families,
            'genus' => $request->genus,
            'species' => $request->species,
            'deskripsi' => $request->deskripsi,
            'tanaman_id' => $tanaman->id,
        ]);

        return redirect()->route('bio.index', ['tanaman' => $tanaman->nm_tanaman])->with('success', 'Data berhasil ditambahkan.');
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

        // Jika ada gambar baru, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('gambar')) {
            if ($bio->gambar) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $bio->gambar));
            }

            $imagePath = $request->file('gambar')->store('hama_images', 'public');
            $validatedData['gambar'] = '/storage/' . $imagePath; // Simpan path lengkap
        } else {
            $validatedData['gambar'] = $bio->gambar; // Tetap pakai gambar lama
        }
        if ($request->hasFile('sebaran')) {
            if ($bio->sebaran) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $bio->sebaran));
            }

            $imagePath = $request->file('sebaran')->store('hama_images', 'public');
            $validatedData['sebaran'] = '/storage/' . $imagePath; // Simpan path lengkap
        } else {
            $validatedData['sebaran'] = $bio->sebaran; // Tetap pakai gambar lama
        }

        $bio->update($validatedData);

        return redirect()->route('bio.index', $tanaman->nm_tanaman)
            ->with('success', 'Data berhasil diperbarui!');
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
