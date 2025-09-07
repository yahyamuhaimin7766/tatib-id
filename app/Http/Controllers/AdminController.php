<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function uploadStudents(Request $request)
    {
        $request->validate(['file_siswa' => 'required|mimes: xls,xlsx']);

        try {
            Excel::import(new StudentsImport, $request->file('file_siswa'));
            return back()->with('success', 'Data siswa berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor file. Pastikan format header (nama, kelas) sudah benar. Error: ' . $e->getMessage());
        }
    }
}