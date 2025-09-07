<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    /**
     * Menampilkan form untuk membuat pelanggaran baru.
     */
    public function create()
    {
        return view('violations.create');
    }

    /**
     * Menyimpan data pelanggaran baru ke database.
     */
    // Di dalam ViolationController.php
    public function store(Request $request)
    {
    // ... (logika validasi dan simpan data Anda yang sudah benar) ...
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'kelas' => 'required|string|max:50',
        'pelanggaran' => 'required|string',
        'custom_pelanggaran' => 'nullable|string|max:255',
        'point' => 'required|integer|min:1',
        'tanggal_waktu' => 'required|date',
    ]);

    $student = Student::where('nama', $validatedData['nama'])
                      ->where('kelas', $validatedData['kelas'])
                      ->first();

    if (!$student) {
        $student = Student::create([
            'nama' => $validatedData['nama'],
            'kelas' => $validatedData['kelas'],
            'total_point' => 0,
        ]);
    }
    
    $jenisPelanggaran = $validatedData['pelanggaran'];
    if ($jenisPelanggaran === 'Lainnya' && !empty($validatedData['custom_pelanggaran'])) {
        $jenisPelanggaran = $validatedData['custom_pelanggaran'];
    }

    Violation::create([
        'student_id' => $student->id,
        'pelanggaran' => $jenisPelanggaran,
        'point' => $validatedData['point'],
        'tanggal_waktu' => $validatedData['tanggal_waktu'],
        'input_by' => 'admin'
    ]);

    $student->updateTotalPoint();

    // PASTIKAN BARIS INI MENGARAH KE 'reports.index'
    return redirect()->route('reports.index')->with('success', 'Pelanggaran berhasil ditambahkan!');
    }
    /**
     * API untuk autocomplete nama siswa.
     */
    public function searchStudents(Request $request)
    {
        $query = $request->get('q');
        $students = Student::where('nama', 'like', "%{$query}%")
            ->select('nama', 'kelas')
            ->distinct()
            ->limit(10)
            ->get();

        return response()->json($students);
    }

    /**
     * Menampilkan detail satu data pelanggaran.
     */
    public function show(Violation $violation)
    {
        return view('violations.show', compact('violation'));
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(Violation $violation)
    {
        $students = Student::orderBy('nama')->get();
        return view('violations.edit', compact('violation', 'students'));
    }

    /**
     * Menyimpan perubahan dari form edit ke database.
     */
    public function update(Request $request, Violation $violation)
    {
        // Validasi disesuaikan dengan nama input di form
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'pelanggaran' => 'required|string|max:255', // <--- DIPERBAIKI
            'point' => 'required|integer|min:1',
        ]);

        $violation->update($validatedData);

        return redirect()->route('reports.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggaran dari database.
     */
    public function destroy(Violation $violation)
    {
        $violation->delete();
        return redirect()->route('reports.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }

     public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $ids = $request->input('ids');

        // Dapatkan semua siswa yang pelanggarannya akan dihapus
        $studentsToUpdate = Violation::whereIn('id', $ids)->pluck('student_id')->unique();
        
        Violation::whereIn('id', $ids)->delete();

        // Update total poin untuk semua siswa yang terpengaruh
        if ($studentsToUpdate->isNotEmpty()) {
            $students = Student::findMany($studentsToUpdate);
            foreach ($students as $student) {
                $student->updateTotalPoint();
            }
        }

        return redirect()->route('reports.index')->with('success', 'Data pelanggaran yang dipilih berhasil dihapus.');
    }
}
