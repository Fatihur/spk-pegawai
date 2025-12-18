@extends('layouts.app')
@section('title', 'Detail Penilaian')
@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('penilaian.show') }}" method="GET" class="row g-3 align-items-end">
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
            @if($periode && count($penilaian) > 0)
            @php $sudahDihitung = \App\Models\Hasil::where('periode', $periode)->exists(); @endphp
            <div class="col-md-6 text-md-end">
                @if(!$sudahDihitung)
                <a href="{{ route('penilaian.create', ['periode' => $periode]) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit Penilaian</a>
                <a href="{{ route('perhitungan.hitung', ['periode' => $periode]) }}" class="btn btn-success"><i class="bi bi-calculator me-1"></i>Hitung MFEP</a>
                @else
                <a href="{{ route('perbandingan', ['periode' => $periode]) }}" class="btn btn-info"><i class="bi bi-trophy me-1"></i>Lihat Hasil</a>
                @endif
            </div>
            @endif
        </form>
    </div>
</div>

@if($periode && count($penilaian) > 0)
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Data Penilaian Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h5>
        <div>
            <span class="badge bg-primary me-2">{{ count($penilaian) }} Pegawai</span>
            @php $sudahDihitung = \App\Models\Hasil::where('periode', $periode)->exists(); @endphp
            @if($sudahDihitung)
            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Sudah Dihitung</span>
            @else
            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Belum Dihitung</span>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" id="dataTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        @foreach($kriteria as $k)
                        <th class="text-center">{{ $k->kode }}<br><small class="text-muted fw-normal">{{ $k->nama }}</small></th>
                        @endforeach
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaian as $i => $p)
                    @php
                        $total = array_sum($p['nilai']);
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $p['pegawai']->nama }}</strong></td>
                        <td><small class="text-muted">{{ $p['pegawai']->jabatan }}</small></td>
                        @foreach($kriteria as $k)
                        <td class="text-center">
                            @php $nilai = $p['nilai'][$k->id] ?? 0; @endphp
                            <span class="badge bg-{{ $nilai >= 4 ? 'success' : ($nilai >= 3 ? 'warning text-dark' : 'danger') }}">{{ $nilai }}</span>
                        </td>
                        @endforeach
                        <td class="text-center"><strong>{{ $total }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Keterangan Nilai</h6>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-3">
            <span><span class="badge bg-success">5</span> Sangat Baik</span>
            <span><span class="badge bg-success">4</span> Baik</span>
            <span><span class="badge bg-warning text-dark">3</span> Cukup</span>
            <span><span class="badge bg-danger">2</span> Kurang</span>
            <span><span class="badge bg-danger">1</span> Sangat Kurang</span>
        </div>
    </div>
</div>
@elseif($periode)
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Tidak ada data penilaian untuk periode {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}.</div>
@else
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <i class="bi bi-clipboard-data" style="font-size: 3rem;"></i>
        <p class="mt-3 mb-0">Pilih periode untuk melihat detail penilaian</p>
    </div>
</div>
@endif

<a href="{{ route('penilaian.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Periode</a>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('#dataTable').length && $('#dataTable tbody tr').length > 0) {
            $('#dataTable').DataTable({
                paging: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: { first: "«", previous: "‹", next: "›", last: "»" }
                }
            });
        }
    });
</script>
@endsection
