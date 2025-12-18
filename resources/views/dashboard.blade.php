@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people"></i></div>
            <h3>{{ $totalPegawai }}</h3>
            <p>Total Pegawai</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-list-check"></i></div>
            <h3>{{ $totalKriteria }}</h3>
            <p>Total Kriteria</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-clipboard-check"></i></div>
            <h3>{{ $totalPenilaian }}</h3>
            <p>Pegawai Dinilai</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-calculator"></i></div>
            <h3>MFEP</h3>
            <p>Metode SPK</p>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top 5 Pegawai Non-ASN Terbaik</h5>
        <span class="badge bg-primary">Metode MFEP</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Ranking</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th class="text-center">Nilai MFEP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilTerbaru as $h)
                    <tr class="{{ $h->ranking_mfep == 1 ? 'table-success' : '' }}">
                        <td class="text-center">
                            @if($h->ranking_mfep <= 3)
                            <span class="badge bg-{{ $h->ranking_mfep == 1 ? 'warning' : ($h->ranking_mfep == 2 ? 'secondary' : 'danger') }}">
                                <i class="bi bi-trophy-fill me-1"></i>{{ $h->ranking_mfep }}
                            </span>
                            @else
                            <span class="badge bg-light text-dark">{{ $h->ranking_mfep }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $h->pegawai->nama }}</strong></td>
                        <td>{{ $h->pegawai->jabatan }}</td>
                        <td class="text-center"><strong>{{ number_format($h->nilai_mfep, 4) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2">Belum ada data perhitungan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Tentang Sistem</h5>
    </div>
    <div class="card-body">
        <p class="mb-2"><strong>Sistem Penilaian Kinerja Pegawai Non-ASN</strong></p>
        <p class="text-muted small mb-3">Dinas Komunikasi, Informatika dan Statistik (Diskominfotiksan)</p>
        
        <div class="row g-3">
            <div class="col-md-6">
                <div class="border rounded p-3">
                    <h6><i class="bi bi-list-check me-2"></i>Kriteria Penilaian</h6>
                    <ul class="mb-0 small">
                        <li>Kedisiplinan</li>
                        <li>Tanggung Jawab</li>
                        <li>Kerja Sama</li>
                        <li>Kehadiran</li>
                        <li>Produktivitas Kerja</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3">
                    <h6><i class="bi bi-calculator me-2"></i>Metode MFEP</h6>
                    <p class="small mb-2">Multi-Factor Evaluation Process</p>
                    <code class="small">Nilai = Σ (Bobot × Nilai Kriteria)</code>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info mt-3 mb-0 small">
            <i class="bi bi-exclamation-circle me-1"></i>
            Sistem ini memberikan rekomendasi pegawai non-ASN terbaik berdasarkan nilai total akhir, dan belum mencakup kebijakan lanjutan seperti promosi atau insentif.
        </div>
    </div>
</div>
@endsection
