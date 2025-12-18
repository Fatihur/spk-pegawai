<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Hasil;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $kriteria = Kriteria::all();
        $periodes = Penilaian::distinct()->orderBy('periode', 'desc')->pluck('periode');
        
        return view('penilaian.index', compact('pegawai', 'kriteria', 'periodes'));
    }

    public function create(Request $request)
    {
        $periode = $request->get('periode');
        
        if (!$periode) {
            return redirect()->route('penilaian.index')->with('error', 'Pilih periode terlebih dahulu.');
        }

        // Cek apakah periode sudah dihitung - tidak boleh edit
        $sudahDihitung = Hasil::where('periode', $periode)->exists();
        if ($sudahDihitung) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Periode ' . \Carbon\Carbon::parse($periode)->translatedFormat('F Y') . ' sudah dihitung. Penilaian tidak dapat diubah.');
        }

        $pegawai = Pegawai::orderBy('nama')->get();
        $kriteria = Kriteria::orderBy('kode')->get();
        
        // Get existing penilaian for this periode
        $penilaianExisting = [];
        $existing = Penilaian::where('periode', $periode)->get();
        foreach ($existing as $p) {
            $penilaianExisting[$p->pegawai_id][$p->kriteria_id] = $p->nilai;
        }
        
        return view('penilaian.create', compact('pegawai', 'kriteria', 'periode', 'penilaianExisting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|string',
            'nilai' => 'required|array',
            'nilai.*' => 'required|array',
            'nilai.*.*' => 'required|integer|min:1|max:5',
        ]);

        $periode = $validated['periode'];
        
        // Cek apakah periode sudah dihitung - tidak boleh simpan
        $sudahDihitung = Hasil::where('periode', $periode)->exists();
        if ($sudahDihitung) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Periode ' . \Carbon\Carbon::parse($periode)->translatedFormat('F Y') . ' sudah dihitung. Penilaian tidak dapat diubah.');
        }

        $nilaiData = $validated['nilai'];

        foreach ($nilaiData as $pegawaiId => $kriteriaNilai) {
            foreach ($kriteriaNilai as $kriteriaId => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'pegawai_id' => $pegawaiId,
                        'kriteria_id' => $kriteriaId,
                        'periode' => $periode,
                    ],
                    ['nilai' => $nilai]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian periode ' . \Carbon\Carbon::parse($periode)->translatedFormat('F Y') . ' berhasil disimpan.');
    }

    public function show(Request $request)
    {
        $periode = $request->get('periode');
        $penilaian = [];
        
        if ($periode) {
            $pegawai = Pegawai::orderBy('nama')->get();
            $kriteria = Kriteria::orderBy('kode')->get();
            
            foreach ($pegawai as $p) {
                $nilai = Penilaian::where('pegawai_id', $p->id)
                    ->where('periode', $periode)
                    ->pluck('nilai', 'kriteria_id')
                    ->toArray();
                
                if (!empty($nilai)) {
                    $penilaian[] = [
                        'pegawai' => $p,
                        'nilai' => $nilai
                    ];
                }
            }
        }
        
        $periodes = Penilaian::distinct()->orderBy('periode', 'desc')->pluck('periode');
        $kriteria = Kriteria::orderBy('kode')->get();
        
        return view('penilaian.show', compact('penilaian', 'periodes', 'kriteria', 'periode'));
    }
}
