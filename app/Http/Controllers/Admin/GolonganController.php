<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $golongans = Golongan::latest()->get();
        return view('admin.golongan.index', ['golongans' => $golongans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.golongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nm_golongan' => 'required|string|max:255',
            'bahan' => 'required|string',
        ], [
            'nm_golongan.required' => 'Nama golongan wajib diisi.',
            'nm_golongan.string' => 'Nama golongan harus berupa teks.',
            'nm_golongan.max' => 'Nama golongan maksimal 255 karakter.',
            'bahan.required' => 'Bahan wajib diisi.',
            'bahan.string' => 'Bahan harus berupa teks.',
            'bahan.max' => 'Bahan maksimal 255 karakter.',
        ]);

        // Simpan data ke database
        Golongan::create([
            'nm_golongan' => $request->nm_golongan,
            'bahan' => $request->bahan,
        ]);

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('admin.golongan.edit', compact('golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'nm_golongan' => 'required|string|max:255',
            'bahan' => 'required|string',
        ], [
            'nm_golongan.required' => 'Nama golongan wajib diisi.',
            'nm_golongan.max' => 'Nama golongan maksimal 255 karakter.',
            'bahan.required' => 'Bahan wajib diisi.',
        ]);

        $golongan->update($request->all());

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
