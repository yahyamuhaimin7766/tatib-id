@extends('layouts.app')

@section('title', 'Data Siswa - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Siswa</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru
            </a>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.students.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto"><label for="kelas" class="form-label mb-0 fw-bold">Filter Kelas:</label></div>
                <div class="col-auto">
                    <select name="kelas" id="kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Tampilkan Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->kelas }}" {{ request('kelas') == $class->kelas ? 'selected' : '' }}>
                                {{ $class->kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- FORM UNTUK HAPUS MASSAL --}}
    <form action="{{ route('admin.students.bulk.destroy') }}" method="POST" id="bulk-delete-form-students"
        onsubmit="return confirm('PERINGATAN: Menghapus siswa akan menghapus SEMUA data pelanggaran terkait. Yakin?')">
        @csrf
        @method('DELETE')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-users me-2"></i>Daftar Siswa</h5>
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus yang
                    Dipilih</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 1%;"><input type="checkbox" id="select-all"></th>
                                <th scope="col" style="width: 5%;">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Total Poin</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $index => $student)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="ids[]"
                                            value="{{ $student->id }}" class="item-checkbox"></td>
                                    <td>{{ $students->firstItem() + $index }}</td>
                                    <td>{{ $student->nama }}</td>
                                    <td>{{ $student->kelas }}</td>
                                    <td><span class="badge bg-danger">{{ $student->total_point }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.students.edit', $student->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button type="submit" form="delete-form-student-{{ $student->id }}"
                                            class="btn btn-sm btn-danger" title="Hapus"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">Tidak ada data siswa untuk filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($students->hasPages())
                <div class="card-footer">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </form>

    {{-- FORM-FORM TERSEMBUNYI UNTUK HAPUS INDIVIDUAL --}}
    @foreach ($students as $student)
        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
            id="delete-form-student-{{ $student->id }}" class="d-none"
            onsubmit="return confirm('PERINGATAN: Menghapus siswa ini juga akan menghapus semua data pelanggarannya. Yakin?')">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@section('scripts')
    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
@endsection
