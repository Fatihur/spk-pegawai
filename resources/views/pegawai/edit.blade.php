@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Form Edit Pegawai</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pegawai.update', $pegawai) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP / ID Pegawai</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $pegawai->nip) }}" required>
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pegawai->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Unit Kerja</label>
                    <input type="text" name="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" value="{{ old('unit_kerja', $pegawai->unit_kerja) }}" required>
                    @error('unit_kerja')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
