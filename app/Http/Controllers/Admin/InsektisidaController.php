<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Insektisida;
use Illuminate\Http\Request;

class InsektisidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insektisidas = Insektisida::latest()->get()->map(function ($insektisida) {
            // Konversi string menjadi array
            $crossResistensArray = json_decode($insektisida->cross_resistens, true) ?? [];
            $saranInsektisidaArray = json_decode($insektisida->saran_insektisida, true) ?? [];

            // Ambil nama golongan berdasarkan ID
            $insektisida->cross_resistens_names = Golongan::whereIn('id', $crossResistensArray)
                ->pluck('nm_golongan')
                ->toArray();
            $insektisida->cross_resistens_bahan = Golongan::whereIn('id', $crossResistensArray)
                ->pluck('bahan')
                ->toArray();


            $insektisida->saran_insektisida_names = Golongan::whereIn('id', $saranInsektisidaArray)
                ->pluck('nm_golongan')
                ->toArray();
            $insektisida->saran_insektisida_bahan = Golongan::whereIn('id', $saranInsektisidaArray)
                ->pluck('bahan')
                ->toArray();

            return $insektisida;
        });

        return view('admin.insektisida.index', compact('insektisidas'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $golongans = Golongan::latest()->get();
        return view('admin.insektisida.create', ['golongans' => $golongans]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nm_insektisida' => 'required|string|max:255',
            'cross_resistens' => 'nullable|array',
            'cross_resistens.*' => 'exists:golongans,id',
            'saran_insektisida' => 'nullable|array',
            'saran_insektisida.*' => 'exists:golongans,id',
        ]);

        $insektisida = new Insektisida();
        $insektisida->nm_insektisida = $request->nm_insektisida;
        $insektisida->cross_resistens = json_encode($request->cross_resistens);
        $insektisida->saran_insektisida = json_encode($request->saran_insektisida);
        $insektisida->save();

        return redirect()->route('insektisida.index')->with('success', 'Golongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insektisida $insektisida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insektisida $insektisida)
    {
        $golongans = Golongan::all();

        // Pastikan cross_resistens dan saran_insektisida dalam bentuk array
        $selectedCrossResistens = json_decode($insektisida->cross_resistens, true) ?? [];
        $selectedSaranInsektisida = json_decode($insektisida->saran_insektisida, true) ?? [];

        return view('admin.insektisida.edit', compact('insektisida', 'golongans', 'selectedCrossResistens', 'selectedSaranInsektisida'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insektisida $insektisida)
    {
        $request->validate([
            'nm_insektisida' => 'required|string|max:255',
            'cross_resistens' => 'nullable|array',
            'saran_insektisida' => 'nullable|array',
        ]);

        $insektisida->update([
            'nm_insektisida' => $request->nm_insektisida,
            'cross_resistens' => json_encode($request->cross_resistens), // Simpan dalam JSON
            'saran_insektisida' => json_encode($request->saran_insektisida),
        ]);

        return redirect()->route('insektisida.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insektisida $insektisida)
    {
        $insektisida->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
