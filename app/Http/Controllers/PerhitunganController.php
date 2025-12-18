<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Hasil;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PerhitunganController extends Controller
{
    public function index()
    {
        $periodes = Penilaian::distinct()->orderBy('periode', 'desc')->pluck('periode');
        
        // Ambil periode yang sudah dihitung
        $periodeSudahDihitung = Hasil::distinct()->pluck('periode')->toArray();
        
        return view('perhitungan.index', compact('periodes', 'periodeSudahDihitung'));
    }

    public function hitung(Request $request)
    {
        $periode = $request->get('periode');
        
        if (!$periode) {
            return redirect()->route('perhitungan.index')->with('error', 'Pilih periode terlebih dahulu.');
        }

        // Cek apakah periode sudah pernah dihitung
        $sudahDihitung = Hasil::where('periode', $periode)->exists();
        if ($sudahDihitung) {
            return redirect()->route('perbandingan', ['periode' => $periode])
                ->with('error', 'Periode ini sudah pernah dihitung. Silakan lihat hasil yang sudah ada.');
        }

        $kriteria = Kriteria::all();
        $pegawaiIds = Penilaian::where('periode', $periode)->distinct()->pluck('pegawai_id');
        $pegawai = Pegawai::whereIn('id', $pegawaiIds)->get();

        if ($pegawai->isEmpty()) {
            return redirect()->route('perhitungan.index')->with('error', 'Tidak ada data penilaian untuk periode ini.');
        }

        // Ambil semua nilai
        $nilaiMatrix = [];
        foreach ($pegawai as $p) {
            $nilai = Penilaian::where('pegawai_id', $p->id)
                ->where('periode', $periode)
                ->pluck('nilai', 'kriteria_id')
                ->toArray();
            $nilaiMatrix[$p->id] = $nilai;
        }

        // Hitung MFEP
        $hasilMfep = $this->hitungMFEP($pegawai, $kriteria, $nilaiMatrix);

        // Simpan hasil
        foreach ($pegawai as $p) {
            Hasil::updateOrCreate(
                ['pegawai_id' => $p->id, 'periode' => $periode],
                [
                    'nilai_mfep' => $hasilMfep[$p->id]['nilai'],
                    'ranking_mfep' => $hasilMfep[$p->id]['ranking'],
                ]
            );
        }

        // Detail perhitungan MFEP per pegawai
        $detailMfep = $this->getDetailMFEP($pegawai, $kriteria, $nilaiMatrix);

        return view('perhitungan.hasil', compact('pegawai', 'kriteria', 'nilaiMatrix', 'hasilMfep', 'detailMfep', 'periode'));
    }

    private function hitungMFEP($pegawai, $kriteria, $nilaiMatrix)
    {
        $hasil = [];
        
        foreach ($pegawai as $p) {
            $total = 0;
            foreach ($kriteria as $k) {
                $nilai = $nilaiMatrix[$p->id][$k->id] ?? 0;
                // MFEP: Nilai Total = Σ (Bobot × Nilai)
                $total += $nilai * $k->bobot;
            }
            $hasil[$p->id] = ['nilai' => round($total, 4), 'ranking' => 0];
        }

        // Ranking berdasarkan nilai tertinggi
        uasort($hasil, fn($a, $b) => $b['nilai'] <=> $a['nilai']);
        $rank = 1;
        foreach ($hasil as $id => &$h) {
            $h['ranking'] = $rank++;
        }

        return $hasil;
    }

    private function getDetailMFEP($pegawai, $kriteria, $nilaiMatrix)
    {
        $detail = [];
        
        foreach ($pegawai as $p) {
            $detail[$p->id] = [];
            foreach ($kriteria as $k) {
                $nilai = $nilaiMatrix[$p->id][$k->id] ?? 0;
                $bobot = $k->bobot;
                $weighted = $nilai * $bobot;
                $detail[$p->id][$k->id] = [
                    'nilai' => $nilai,
                    'bobot' => $bobot,
                    'weighted' => round($weighted, 4),
                ];
            }
        }
        
        return $detail;
    }

    public function perbandingan(Request $request)
    {
        $periode = $request->get('periode');
        $periodes = Penilaian::distinct()->pluck('periode');
        
        $hasil = [];
        $kriteria = [];
        $nilaiMatrix = [];
        
        if ($periode) {
            $hasil = Hasil::with('pegawai')
                ->where('periode', $periode)
                ->orderBy('ranking_mfep')
                ->get();
            
            // Ambil data kriteria dan nilai untuk detail
            $kriteria = Kriteria::all();
            $pegawaiIds = $hasil->pluck('pegawai_id');
            
            foreach ($pegawaiIds as $pegawaiId) {
                $nilai = Penilaian::where('pegawai_id', $pegawaiId)
                    ->where('periode', $periode)
                    ->pluck('nilai', 'kriteria_id')
                    ->toArray();
                $nilaiMatrix[$pegawaiId] = $nilai;
            }
        }

        return view('perhitungan.perbandingan', compact('hasil', 'periodes', 'periode', 'kriteria', 'nilaiMatrix'));
    }

    public function exportPdf(Request $request)
    {
        $periode = $request->get('periode');
        
        $hasil = Hasil::with('pegawai')
            ->where('periode', $periode)
            ->orderBy('ranking_mfep')
            ->get();

        $kriteria = Kriteria::all();
        
        // Ambil nilai matrix untuk detail
        $nilaiMatrix = [];
        foreach ($hasil as $h) {
            $nilai = Penilaian::where('pegawai_id', $h->pegawai_id)
                ->where('periode', $periode)
                ->pluck('nilai', 'kriteria_id')
                ->toArray();
            $nilaiMatrix[$h->pegawai_id] = $nilai;
        }

        $pdf = Pdf::loadView('laporan.pdf', compact('hasil', 'periode', 'kriteria', 'nilaiMatrix'));
        
        return $pdf->download('laporan-penilaian-mfep-' . $periode . '.pdf');
    }
}
