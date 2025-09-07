@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Pelanggaran</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-edit me-2"></i>Ubah Data Pelanggaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('violations.update', $violation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="student_id" class="form-label">Nama Siswa *</label>
                    <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id"
                        required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ $violation->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->nama }} ({{ $student->kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pelanggaran" class="form-label">Jenis Pelanggaran *</label>
                    <input type="text" class="form-control @error('pelanggaran') is-invalid @enderror" id="pelanggaran"
                        name="pelanggaran" value="{{ old('pelanggaran', $violation->pelanggaran) }}" required>
                    @error('pelanggaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TAMBAHKAN KEMBALI BLOK KODE INI --}}
                <div class="mb-3">
                    <label for="point" class="form-label">Poin *</label>
                    <input type="number" class="form-control @error('point') is-invalid @enderror" id="point"
                        name="point" value="{{ old('point', $violation->point) }}" required>
                    @error('point')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
