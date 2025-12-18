@extends('layouts.app')
@section('title', 'Hasil Perhitungan MFEP')
@section('content')
<div class="alert alert-success mb-4">
    <i class="bi bi-check-circle me-2"></i>Perhitungan MFEP berhasil untuk periode <strong>{{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</strong>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Matrix Nilai Awal</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Alternatif (Pegawai)</th>
                        @foreach($kriteria as $k)
                        <th class="text-center">{{ $k->kode }}<br><small class="text-muted">{{ $k->nama }}</small></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        @foreach($kriteria as $k)
                        <td class="text-center">{{ $nilaiMatrix[$p->id][$k->id] ?? 0 }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-percent me-2"></i>Bobot Kriteria</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        @foreach($kriteria as $k)
                        <th class="text-center">{{ $k->kode }} - {{ $k->nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($kriteria as $k)
                        <td class="text-center"><strong>{{ $k->bobot * 100 }}%</strong></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header" style="background: #4f46e5; color: #fff;">
        <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Perhitungan MFEP (Multi-Factor Evaluation Process)</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-4">
            <strong>Rumus MFEP:</strong> Nilai Total = Σ (Bobot × Nilai Kriteria)
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        @foreach($kriteria as $k)
                        <th class="text-center">{{ $k->kode }} × {{ $k->bobot }}</th>
                        @endforeach
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        @foreach($kriteria as $k)
                        <td class="text-center">
                            {{ $detailMfep[$p->id][$k->id]['nilai'] }} × {{ $detailMfep[$p->id][$k->id]['bobot'] }} = <strong>{{ $detailMfep[$p->id][$k->id]['weighted'] }}</strong>
                        </td>
                        @endforeach
                        <td class="text-center"><strong class="text-primary">{{ number_format($hasilMfep[$p->id]['nilai'], 4) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Hasil Ranking MFEP</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">Ranking</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th class="text-center">Nilai MFEP</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilMfep as $id => $h)
                @php $peg = $pegawai->find($id); @endphp
                <tr class="{{ $h['ranking'] == 1 ? 'table-success' : '' }}">
                    <td class="text-center">
                        @if($h['ranking'] <= 3)
                        <span class="badge bg-{{ $h['ranking'] == 1 ? 'warning' : ($h['ranking'] == 2 ? 'secondary' : 'danger') }}" style="font-size: 1rem;">
                            <i class="bi bi-trophy-fill me-1"></i>{{ $h['ranking'] }}
                        </span>
                        @else
                        <span class="badge bg-light text-dark">{{ $h['ranking'] }}</span>
                        @endif
                    </td>
                    <td><strong>{{ $peg->nama }}</strong></td>
                    <td>{{ $peg->jabatan }}</td>
                    <td class="text-center"><strong>{{ number_format($h['nilai'], 4) }}</strong></td>
                    <td class="text-center">
                        @if($h['ranking'] == 1)
                        <span class="badge bg-success">Rekomendasi Terbaik</span>
                        @elseif($h['ranking'] <= 3)
                        <span class="badge bg-info">Top 3</span>
                        @else
                        <span class="badge bg-secondary">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-warning">
    <h6 class="mb-2"><i class="bi bi-lightbulb me-1"></i>Kesimpulan & Rekomendasi</h6>
    @php $terbaik = $pegawai->find(array_key_first($hasilMfep)); @endphp
    <p class="mb-0">Berdasarkan perhitungan metode <strong>MFEP (Multi-Factor Evaluation Process)</strong>, pegawai non-ASN dengan kinerja terbaik adalah <strong>{{ $terbaik->nama }}</strong> ({{ $terbaik->jabatan }}) dengan nilai total <strong>{{ number_format($hasilMfep[$terbaik->id]['nilai'], 4) }}</strong>.</p>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    <a href="{{ route('perbandingan', ['periode' => $periode]) }}" class="btn btn-info"><i class="bi bi-bar-chart me-1"></i>Lihat Hasil</a>
    <a href="{{ route('laporan.pdf', ['periode' => $periode]) }}" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>Download PDF</a>
</div>
@endsection
