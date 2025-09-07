@extends('layouts.app')

@section('title', 'Input Pelanggaran - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Input Pelanggaran</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus me-2"></i>Tambah Pelanggaran Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('violations.store') }}" method="POST">
                        @csrf
                        {{-- Nama Siswa & Kelas (dengan Autocomplete) --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Siswa *</label>
                            {{-- ID sudah benar 'nama' --}}
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                            <div class="form-text">Ketik nama siswa untuk mencari otomatis.</div>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas *</label>
                            {{-- ID sudah benar 'kelas' --}}
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                                name="kelas" value="{{ old('kelas') }}" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Pelanggaran & Point (dengan Autofill) --}}
                        <div class="mb-3">
                            <label for="pelanggaran" class="form-label">Jenis Pelanggaran *</label>
                            <select class="form-select @error('pelanggaran') is-invalid @enderror" id="pelanggaran"
                                name="pelanggaran" required>
                                <option value="">Pilih Pelanggaran</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Tidak memakai seragam lengkap">Tidak memakai seragam lengkap</option>
                                <option value="Tidak membawa buku">Tidak membawa buku</option>
                                <option value="Tidak mengerjakan tugas">Tidak mengerjakan tugas</option>
                                <option value="Berbicara tidak sopan">Berbicara tidak sopan</option>
                                <option value="Merokok">Merokok</option>
                                <option value="Membawa HP saat pelajaran">Membawa HP saat pelajaran</option>
                                <option value="Keluar kelas tanpa izin">Keluar kelas tanpa izin</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="custom-violation" style="display: none;">
                            <label for="custom_pelanggaran" class="form-label">Tuliskan Pelanggaran Lainnya</label>
                            <input type="text" class="form-control" id="custom_pelanggaran" name="custom_pelanggaran">
                        </div>
                        <div class="mb-3">
                            <label for="point" class="form-label">Point Pelanggaran *</label>
                            <input type="number" class="form-control @error('point') is-invalid @enderror" id="point"
                                name="point" value="{{ old('point') }}" min="1" required>
                            @error('point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal & Waktu Kejadian --}}
                        <div class="mb-3">
                            <label for="tanggal_waktu" class="form-label">Tanggal & Waktu Kejadian *</label>
                            <input type="datetime-local" class="form-control @error('tanggal_waktu') is-invalid @enderror"
                                id="tanggal_waktu" name="tanggal_waktu"
                                value="{{ old('tanggal_waktu', now()->format('Y-m-d\TH:i')) }}" required>
                            <div class="form-text">Nilai default adalah waktu sekarang, tapi bisa diubah sesuai waktu
                                kejadian.</div>
                            @error('tanggal_waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pelanggaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Panduan Point --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6><i class="fas fa-info-circle me-2"></i>Panduan Point</h6>
                </div>
                <div class="card-body">
                    <small>
                        <strong>Ringan (1-10 point):</strong><br>• Terlambat: 5 point<br>• Tidak membawa buku: 3
                        point<br><br>
                        <strong>Sedang (11-25 point):</strong><br>• Tidak mengerjakan tugas: 15 point<br>• Tidak berseragam
                        lengkap: 20 point<br><br>
                        <strong>Berat (26-50 point):</strong><br>• Berbicara tidak sopan: 30 point<br>• Keluar kelas tanpa
                        izin: 25 point<br><br>
                        <strong>Sangat Berat (51-100 point):</strong><br>• Merokok: 75 point<br>• Membawa HP saat pelajaran:
                        50 point
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- ======================================================= --}}
    {{-- SCRIPT LENGKAP UNTUK SEMUA FITUR INTERAKTIF --}}
    {{-- ======================================================= --}}
    <script>
        $(function() {
            // Script untuk Autocomplete Nama Siswa
            $("#nama").autocomplete({
                source: "{{ route('students.search') }}",
                minLength: 2,
                select: function(event, ui) {
                    $('#nama').val(ui.item.value);
                    $('#kelas').val(ui.item.kelas);
                    return false;
                }
            });

            // Script untuk Autofill Point dan menampilkan input 'Lainnya'
            $('#pelanggaran').on('change', function() {
                const selectedViolation = $(this).val();

                if (selectedViolation === 'Lainnya') {
                    $('#custom-violation').slideDown();
                    $('#custom_pelanggaran').attr('required', true);
                    $('#point').val('').focus();
                } else {
                    $('#custom-violation').slideUp();
                    $('#custom_pelanggaran').removeAttr('required');
                }

                const pointMap = {
                    'Terlambat': 5,
                    'Tidak membawa buku': 3,
                    'Tidak mengerjakan tugas': 15,
                    'Tidak memakai seragam lengkap': 20,
                    'Berbicara tidak sopan': 30,
                    'Keluar kelas tanpa izin': 25,
                    'Membawa HP saat pelajaran': 50,
                    'Merokok': 75
                };

                if (pointMap[selectedViolation]) {
                    $('#point').val(pointMap[selectedViolation]);
                }
            });
        });
    </script>
@endsection
