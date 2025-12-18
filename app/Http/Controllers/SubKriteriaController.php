<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index(Kriteria $kriteria)
    {
        $subKriteria = $kriteria->subKriteria()->orderBy('nilai', 'desc')->get();
        return view('subkriteria.index', compact('kriteria', 'subKriteria'));
    }

    public function store(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nilai' => 'required|integer|min:1|max:5',
        ]);

        $kriteria->subKriteria()->create($validated);

        return redirect()->route('subkriteria.index', $kriteria)->with('success', 'Sub kriteria berhasil ditambahkan.');
    }

    public function destroy(Kriteria $kriteria, SubKriteria $subkriteria)
    {
        $subkriteria->delete();
        return redirect()->route('subkriteria.index', $kriteria)->with('success', 'Sub kriteria berhasil dihapus.');
    }
}
