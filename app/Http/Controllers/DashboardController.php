<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Hasil;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPegawai = Pegawai::count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::distinct('pegawai_id')->count('pegawai_id');
        $hasilTerbaru = Hasil::with('pegawai')
            ->orderBy('ranking_mfep')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalPegawai', 'totalKriteria', 'totalPenilaian', 'hasilTerbaru'));
    }
}
