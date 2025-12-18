@extends('layouts.app')
@section('title', 'Penilaian Kinerja')
@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Periode Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('penilaian.create') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Pilih Periode Penilaian</label>
                        <input type="month" name="periode" class="form-control" value="{{ date('Y-m') }}" required>
                        <small class="text-muted">Pilih bulan dan tahun periode penilaian</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-right me-1"></i>Lanjut Input Penilaian
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-people me-2 text-primary"></i>Total Pegawai</span>
                        <span class="badge bg-primary rounded-pill">{{ $pegawai->count() }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-list-check me-2 text-success"></i>Total Kriteria</span>
                        <span class="badge bg-success rounded-pill">{{ $kriteria->count() }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar-check me-2 text-info"></i>Total Periode</span>
                        <span class="badge bg-info rounded-pill">{{ $periodes->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Daftar Periode Penilaian</h5>
            </div>
            <div class="card-body p-0">
                @if($periodes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th class="text-center">Jumlah Pegawai Dinilai</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periodes as $i => $p)
                            @php
                                $jumlahDinilai = \App\Models\Penilaian::where('periode', $p)->distinct('pegawai_id')->count('pegawai_id');
                                $sudahDihitung = \App\Models\Hasil::where('periode', $p)->exists();
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($p)->translatedFormat('F Y') }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $jumlahDinilai }} pegawai</span>
                                </td>
                                <td class="text-center">
                                    @if($sudahDihitung)
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Sudah Dihitung</span>
                                    @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Belum Dihitung</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('penilaian.show', ['periode' => $p]) }}" class="btn btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(!$sudahDihitung)
                                        <a href="{{ route('penilaian.create', ['periode' => $p]) }}" class="btn btn-outline-warning" title="Edit Penilaian">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('perhitungan.hitung', ['periode' => $p]) }}" class="btn btn-outline-success" title="Hitung MFEP">
                                            <i class="bi bi-calculator"></i>
                                        </a>
                                        @else
                                        <a href="{{ route('perbandingan', ['periode' => $p]) }}" class="btn btn-outline-primary" title="Lihat Hasil">
                                            <i class="bi bi-trophy"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">Belum ada periode penilaian</p>
                    <p class="small">Silakan tambah periode baru di form sebelah kiri</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
