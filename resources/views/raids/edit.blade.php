@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Hasil Razia</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-edit me-2"></i>Ubah Data Sitaan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('raids.update', $raid->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Penting untuk form edit --}}

                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama Siswa *</label>
                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa"
                        name="nama_siswa" value="{{ old('nama_siswa', $raid->nama_siswa) }}" required>
                    @error('nama_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas *</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                        name="kelas" value="{{ old('kelas', $raid->kelas) }}" required>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="foto_barang" class="form-label">Ganti Foto Barang Sitaan</label>
                    @if ($raid->foto_barang)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $raid->foto_barang) }}" alt="Foto saat ini" width="150"
                                class="img-thumbnail">
                        </div>
                    @endif
                    <input class="form-control @error('foto_barang') is-invalid @enderror" type="file" id="foto_barang"
                        name="foto_barang">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                    @error('foto_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="penanggung_jawab" class="form-label">Penanggung Jawab (Guru/Staf) *</label>
                    <input type="text" class="form-control @error('penanggung_jawab') is-invalid @enderror"
                        id="penanggung_jawab" name="penanggung_jawab"
                        value="{{ old('penanggung_jawab', $raid->penanggung_jawab) }}" required>
                    @error('penanggung_jawab')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $raid->keterangan) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('raids.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
