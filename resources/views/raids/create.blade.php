@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Input Hasil Razia</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-search me-2"></i>Catat Barang Hasil Razia</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('raids.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Nama Siswa --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Siswa *</label>
                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama"
                        name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                    @error('nama_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas *</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                        name="kelas" value="{{ old('kelas') }}" required>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto Barang --}}
                <div class="mb-3">
                    <label for="foto_barang" class="form-label">Foto Barang Sitaan</label>
                    <input class="form-control @error('foto_barang') is-invalid @enderror" type="file" id="foto_barang"
                        name="foto_barang">
                    <div class="form-text">Opsional, jika ada barang yang difoto.</div>
                    @error('foto_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penanggung Jawab --}}
                <div class="mb-3">
                    <label for="penanggung_jawab" class="form-label">Penanggung Jawab (Guru/Staf) *</label>
                    <input type="text" class="form-control @error('penanggung_jawab') is-invalid @enderror"
                        id="penanggung_jawab" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" required>
                    @error('penanggung_jawab')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <p class="form-text">Tanggal & waktu akan tercatat otomatis.</p>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Script untuk Autocomplete (menggunakan ID 'nama' dan 'kelas')
            $("#nama").autocomplete({
                source: "{{ route('students.search') }}",
                minLength: 2,
                select: function(event, ui) {
                    $('#nama').val(ui.item.value);
                    $('#kelas').val(ui.item.kelas);
                    return false;
                }
            });
        });
    </script>
@endsection
