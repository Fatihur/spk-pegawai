@extends('layouts.app')
@section('title', 'Hasil Penilaian Kinerja')
@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('perbandingan') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4 col-sm-6">
                <label class="form-label">Pilih Periode</label>
                <select name="periode" class="form-select">
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periodes as $p)
                    <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ \Carbon\Carbon::parse($p)->translatedFormat('F Y') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            @if($periode && $hasil->count() > 0)
            <div class="col-md-6 text-md-end">
                <a href="{{ route('laporan.pdf', ['periode' => $periode]) }}" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>Download PDF</a>
            </div>
            @endif
        </form>
    </div>
</div>

@if($periode && $hasil->count() > 0)
<div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: #4f46e5; color: #fff;">
        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Hasil Penilaian Kinerja Pegawai Non-ASN (Metode MFEP)</h5>
        <span class="badge bg-light text-dark">Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th class="text-center">Ranking</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    @foreach($kriteria as $k)
                    <th class="text-center">{{ $k->kode }}</th>
                    @endforeach
                    <th class="text-center">Nilai MFEP</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr class="{{ $h->ranking_mfep == 1 ? 'table-success' : '' }}">
                    <td class="text-center">
                        @if($h->ranking_mfep <= 3)
                        <span class="badge bg-{{ $h->ranking_mfep == 1 ? 'warning' : ($h->ranking_mfep == 2 ? 'secondary' : 'danger') }}" style="font-size: 1rem;">
                            <i class="bi bi-trophy-fill me-1"></i>{{ $h->ranking_mfep }}
                        </span>
                        @else
                        <span class="badge bg-light text-dark">{{ $h->ranking_mfep }}</span>
                        @endif
                    </td>
                    <td><strong>{{ $h->pegawai->nama }}</strong></td>
                    <td>{{ $h->pegawai->jabatan }}</td>
                    <td>{{ $h->pegawai->unit_kerja }}</td>
                    @foreach($kriteria as $k)
                    <td class="text-center">{{ $nilaiMatrix[$h->pegawai_id][$k->id] ?? '-' }}</td>
                    @endforeach
                    <td class="text-center"><strong>{{ number_format($h->nilai_mfep, 4) }}</strong></td>
                    <td class="text-center">
                        @if($h->ranking_mfep == 1)
                        <span class="badge bg-success">Rekomendasi Terbaik</span>
                        @elseif($h->ranking_mfep <= 3)
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

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Kriteria Penilaian</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th class="text-center">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $k)
                        <tr>
                            <td>{{ $k->kode }}</td>
                            <td>{{ $k->nama }}</td>
                            <td class="text-center">{{ $k->bobot * 100 }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="2"><strong>Total Bobot</strong></td>
                            <td class="text-center"><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-calculator me-2"></i>Metode MFEP</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Multi-Factor Evaluation Process (MFEP)</strong></p>
                <p class="text-muted small mb-3">Metode pengambilan keputusan yang mengevaluasi alternatif berdasarkan beberapa faktor/kriteria dengan bobot tertentu.</p>
                <div class="alert alert-light mb-0">
                    <strong>Rumus:</strong><br>
                    <code>Nilai Total = Σ (Bobot × Nilai Kriteria)</code>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-warning">
    <h6 class="mb-2"><i class="bi bi-lightbulb me-1"></i>Kesimpulan & Rekomendasi</h6>
    <p class="mb-0">Berdasarkan hasil perhitungan menggunakan metode <strong>MFEP (Multi-Factor Evaluation Process)</strong>, pegawai non-ASN dengan kinerja terbaik adalah <strong>{{ $hasil->first()->pegawai->nama }}</strong> ({{ $hasil->first()->pegawai->jabatan }}) dengan nilai <strong>{{ number_format($hasil->first()->nilai_mfep, 4) }}</strong>.</p>
    <hr>
    <p class="mb-0 small text-muted"><i class="bi bi-exclamation-circle me-1"></i>Catatan: Sistem ini hanya memberikan rekomendasi hasil penilaian kinerja pegawai non-ASN terbaik berdasarkan nilai total akhir, dan belum mencakup proses kebijakan lanjutan seperti promosi jabatan atau pemberian insentif.</p>
</div>
@elseif($periode)
<div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>Belum ada data hasil perhitungan untuk periode {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}. Silakan lakukan perhitungan terlebih dahulu.</div>
@else
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <i class="bi bi-bar-chart" style="font-size: 48px;"></i>
        <p class="mt-3 mb-0">Pilih periode untuk melihat hasil penilaian kinerja</p>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('#dataTable').length && $('#dataTable tbody tr').length > 0) {
            $('#dataTable').DataTable({
                paging: false,
                ordering: false,
                info: false,
                language: {
                    search: "Cari:",
                    zeroRecords: "Data tidak ditemukan",
                }
            });
        }
    });
</script>
@endsection
