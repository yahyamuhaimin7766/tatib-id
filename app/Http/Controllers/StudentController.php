<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar semua siswa.
     */
    public function index(Request $request)
    {
        $studentsQuery = Student::query()->orderBy('nama');

        if ($request->filled('kelas') && $request->kelas != 'all') {
            $studentsQuery->where('kelas', $request->kelas);
        }

        $students = $studentsQuery->paginate(15)->appends($request->query());
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Menampilkan form untuk menambah siswa baru.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Menyimpan data siswa baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required','string','max:255',Rule::unique('students')->where(fn ($query) => $query->where('kelas', $request->kelas))],
            'kelas' => 'required|string|max:50',
            'nis' => 'nullable|string|max:50|unique:students,nis',
        ]);
        $validatedData['total_point'] = 0;
        Student::create($validatedData);
        return redirect()->route('admin.students.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data siswa.
     */
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Menyimpan perubahan dari form edit.
     */
    public function update(Request $request, Student $student)
    {
        $validatedData = $request->validate([
            'nama' => ['required','string','max:255',Rule::unique('students')->where(fn ($query) => $query->where('kelas', $request->kelas))->ignore($student->id)],
            'kelas' => 'required|string|max:50',
            'nis' => ['nullable','string','max:50',Rule::unique('students')->ignore($student->id)],
        ]);
        $student->update($validatedData);
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dan semua pelanggaran terkait.
     */
    public function destroy(Student $student)
    {
        $student->violations()->delete();
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa dan semua pelanggaran terkait berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        
        $students = Student::where('nama', 'LIKE', '%' . $term . '%')
                           ->orWhere('kelas', 'LIKE', '%' . $term . '%')
                           ->limit(10)
                           ->get(['nama', 'kelas']);
        
        // Memformat data menjadi JSON yang dimengerti oleh jQuery UI
        $formattedStudents = [];
        foreach ($students as $student) {
            $formattedStudents[] = [
                'label' => $student->nama . ' (' . $student->kelas . ')',
                'value' => $student->nama,
                'kelas' => $student->kelas,
            ];
        }

        return response()->json($formattedStudents);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $ids = $request->input('ids');

        DB::transaction(function () use ($ids) {
            // Hapus semua "anak" (pelanggaran) terlebih dahulu
            Violation::whereIn('student_id', $ids)->delete();
            // Baru hapus "induk" (siswa)
            Student::whereIn('id', $ids)->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Data siswa yang dipilih berhasil dihapus.');
    }
}