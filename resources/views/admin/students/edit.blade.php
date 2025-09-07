@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Data Siswa</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-user-edit me-2"></i>Form Edit Siswa</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk form edit --}}

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap Siswa *</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama', $student->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas *</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                        name="kelas" value="{{ old('kelas', $student->kelas) }}" required>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS (Opsional)</label>
                    <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis"
                        name="nis" value="{{ old('nis', $student->nis) }}">
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
