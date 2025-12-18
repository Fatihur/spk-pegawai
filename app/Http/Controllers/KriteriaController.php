<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::with('subKriteria')->latest()->get();
        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:kriteria,kode',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:benefit,cost',
        ]);

        $validated['bobot'] = $validated['bobot'] / 100;
        Kriteria::create($validated);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:kriteria,kode,' . $kriteria->id,
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:benefit,cost',
        ]);

        $validated['bobot'] = $validated['bobot'] / 100;
        $kriteria->update($validated);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
