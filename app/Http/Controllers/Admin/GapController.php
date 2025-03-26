<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gap;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'usia' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'tanaman_id' => 'required|exists:tanamans,id'
        ], [
            'gambar.required' => 'Gambar wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'usia.required' => 'Usia wajib diisi.',
            'gaprequired' => 'Kegiatan wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'tanaman_id.required' => 'Tanaman harus dipilih.',
            'tanaman_id.exists' => 'Tanaman tidak ditemukan.'
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gap', 'public');
            $gambarUrl = Storage::url($gambarPath);
        }

        Gap::create([
            'gambar' => $gambarUrl,
            'usia' => $request->usia,
            'kegiatan' => $request->kegiatan,
            'keterangan' => $request->keterangan,
            'tanaman_id' => $request->tanaman_id,
        ]);

        return redirect()->route('gap.index', ['tanaman' => $tanaman->nm_tanaman])->with('success', 'Kegiatan berhasil ditambahkan!');
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
            if ($gap->gambar) {
                unlink(public_path($gap->gambar));
            }
            $gambarPath = $request->file('gambar')->store('gap', 'public');
            $gambarUrl = Storage::url($gambarPath);
            $gap->gambar = $gambarUrl;
        }

        $gap->update([
            'usia' => $request->usia,
            'kegiatan' => $request->kegiatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('gap.index', ['tanaman' => $tanaman->nm_tanaman])->with('success', 'Kegiatan berhasil diperbarui!');
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
