@extends('layouts.app')
@section('title', 'Edit Kriteria')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Form Edit Kriteria</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kriteria.update', $kriteria) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $kriteria->kode) }}" required>
                    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kriteria</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kriteria->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bobot (%)</label>
                    <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror" value="{{ old('bobot', $kriteria->bobot * 100) }}" min="0" max="100" step="0.01" required>
                    @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kriteria</label>
                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                        <option value="benefit" {{ old('jenis', $kriteria->jenis) == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('jenis', $kriteria->jenis) == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
