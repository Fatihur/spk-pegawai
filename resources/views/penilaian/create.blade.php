@extends('layouts.app')
@section('title', 'Input Penilaian - ' . \Carbon\Carbon::parse($periode)->translatedFormat('F Y'))
@section('content')
<div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5>Input Penilaian Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h5>
        <span class="badge bg-primary">{{ $pegawai->count() }} Pegawai</span>
    </div>
    <div class="card-body">
        <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">
            
            <div class="table-responsive">
                @if($pegawai->isEmpty())
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>Belum ada pegawai yang terdaftar. Silakan tambah pegawai terlebih dahulu.
                    </div>
                @else
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">No</th>
                                <th style="min-width: 200px;">Nama Pegawai</th>
                                @foreach($kriteria as $k)
                                <th class="text-center" style="min-width: 120px;">
                                    {{ $k->kode }}<br>
                                    <small class="text-muted fw-normal">{{ $k->nama }}</small>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pegawai as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $p->nama }}</strong><br>
                                    <small class="text-muted">{{ $p->jabatan }}</small>
                                </td>
                                @foreach($kriteria as $k)
                                @php $nilaiExisting = $penilaianExisting[$p->id][$k->id] ?? ''; @endphp
                                <td class="text-center">
                                    <select name="nilai[{{ $p->id }}][{{ $k->id }}]" class="form-select form-select-sm" required>
                                        <option value="">-</option>
                                        @foreach([5,4,3,2,1] as $v)
                                        <option value="{{ $v }}" {{ $nilaiExisting == $v ? 'selected' : '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            @if($pegawai->isNotEmpty())
            <div class="alert alert-info mt-3">
                <small>
                    <strong>Keterangan Nilai:</strong> 5 = Sangat Baik, 4 = Baik, 3 = Cukup, 2 = Kurang, 1 = Sangat Kurang
                </small>
            </div>
            @endif

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('penilaian.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                @if($pegawai->isNotEmpty())
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Penilaian</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('#dataTable').length > 0) {
            $('#dataTable').DataTable({
                paging: false,
                searching: true,
                info: false,
                ordering: false,
                language: {
                    search: "Cari Pegawai:",
                    zeroRecords: "Pegawai tidak ditemukan"
                }
            });
        }
    });
</script>
@endsection
