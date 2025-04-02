<?php

namespace App\Http\Controllers\Admin;

use App\Models\Panduan;
use App\Models\Tanaman;
use App\Models\Golongan;
use App\Models\Insektisida;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tanaman $tanaman)
    {
        $panduans = $tanaman->panduan;

        $panduans->each(function ($panduan) {
            if ($panduan->insektisida) {
                // Konversi string JSON menjadi array
                $crossResistensArray = json_decode($panduan->insektisida->cross_resistens, true) ?? [];
                $saranInsektisidaArray = json_decode($panduan->insektisida->saran_insektisida, true) ?? [];

                // Ambil nama golongan dan bahan berdasarkan ID
                $panduan->insektisida->cross_resistens_names = Golongan::whereIn('id', $crossResistensArray)
                    ->pluck('nm_golongan')
                    ->toArray();

                $panduan->insektisida->cross_resistens_bahan = Golongan::whereIn('id', $crossResistensArray)
                    ->pluck('bahan')
                    ->toArray();

                $panduan->insektisida->saran_insektisida_names = Golongan::whereIn('id', $saranInsektisidaArray)
                    ->pluck('nm_golongan')
                    ->toArray();

                $panduan->insektisida->saran_insektisida_bahan = Golongan::whereIn('id', $saranInsektisidaArray)
                    ->pluck('bahan')
                    ->toArray();
            }
        });

        return view('admin.panduan.index', compact('tanaman', 'panduans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Tanaman $tanaman)
    {
        $bios = $tanaman->bios;
        $insektisida = Insektisida::latest()->get();

        return view('admin.panduan.create', ['bios' => $bios, 'insektisidas' => $insektisida, 'tanaman' => $tanaman]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tanaman $tanaman)
    {
        $validated = $request->validate([
            'bio_id' => 'required|exists:bios,id',
            'insektisida_id' => 'required|exists:insektisidas,id',
        ]);

        $validated['tanaman_id'] = $tanaman->id;

        // Simpan data ke database
        Panduan::create($validated);

        return redirect()->route('panduan.index', ['tanaman' => $tanaman->nm_tanaman])->with('success', 'Data Panduan berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Panduan $panduan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panduan $panduan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panduan $panduan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panduan $panduan)
    {
        //
    }
}
