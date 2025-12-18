@extends('layouts.app')
@section('title', 'Sub Kriteria: ' . $kriteria->nama)
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Sub Kriteria</h5>
            </div>
            <div class="card-body p-0">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sub Kriteria</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subKriteria as $i => $s)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $s->nama }}</td>
                            <td><span class="badge bg-primary">{{ $s->nilai }}</span></td>
                            <td>
                                <form action="{{ route('subkriteria.destroy', [$kriteria, $s]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary mt-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Tambah Sub Kriteria</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('subkriteria.store', $kriteria) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Sub Kriteria</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai (1-5)</label>
                        <select name="nilai" class="form-select @error('nilai') is-invalid @enderror" required>
                            <option value="5">5 - Sangat Baik</option>
                            <option value="4">4 - Baik</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Sangat Kurang</option>
                        </select>
                        @error('nilai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: { first: "«", previous: "‹", next: "›", last: "»" }
            },
            pageLength: 5,
            columnDefs: [
                { orderable: false, targets: [3] }
            ]
        });
    });
</script>
@endsection
