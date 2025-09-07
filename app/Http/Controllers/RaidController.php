<?php

namespace App\Http\Controllers;

use App\Models\Raid;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RaidController extends Controller
{
    public function index(Request $request)
    {
        $raidsQuery = Raid::query()->latest('tanggal_waktu');

        if ($request->filled('kelas') && $request->kelas != 'all') {
            $raidsQuery->where('kelas', $request->kelas);
        }

        $raids = $raidsQuery->paginate(15)->appends($request->query());
        
        // Ambil daftar kelas dari tabel siswa agar lebih lengkap
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->get();

        return view('raids.index', compact('raids', 'classes'));
    }

    public function create()
    {
        return view('raids.create');
    }

    public function store(Request $request)
    {
        // ... (logika validasi dan simpan data Anda yang sudah benar) ...
        $validatedData = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penanggung_jawab' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->hasFile('foto_barang')) {
            $validatedData['foto_barang'] = $request->file('foto_barang')->store('raids', 'public');
        }

        $validatedData['tanggal_waktu'] = now();
        Raid::create($validatedData);
        // --- PERUBAHAN DI SINI ---
        // Kita menggunakan ->with() yang akan membuat session flash
        return redirect()->route('raids.index')->with('success', 'Data razia berhasil disimpan.');
    }

    public function show(Raid $raid)
    {
        return view('raids.show', compact('raid'));
    }

    public function edit(Raid $raid)
    {
        return view('raids.edit', compact('raid'));
    }

    public function update(Request $request, Raid $raid)
    {
        // ... (logika validasi dan update Anda yang sudah benar) ...
        $validatedData = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penanggung_jawab' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->hasFile('foto_barang')) {
            if ($raid->foto_barang) {
                Storage::delete('public/' . $raid->foto_barang);
            }
            $validatedData['foto_barang'] = $request->file('foto_barang')->store('raids', 'public');
        }

        $raid->update($validatedData);

        // --- PERUBAHAN DI SINI ---
        return redirect()->route('raids.index')->with('success', 'Data razia berhasil diperbarui.');
    }

    public function destroy(Raid $raid)
    {
        if ($raid->foto_barang) {
            Storage::delete('public/' . $raid->foto_barang);
        }
        
        $raid->delete();
        return redirect()->route('raids.index')->with('success', 'Data razia berhasil dihapus.');
    }

     public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        $ids = $request->input('ids');

        // Hapus file foto terkait sebelum menghapus record
        $raidsToDelete = Raid::whereIn('id', $ids)->get();
        foreach ($raidsToDelete as $raid) {
            if ($raid->foto_barang) {
                Storage::delete('public/' . $raid->foto_barang);
            }
        }
        
        Raid::whereIn('id', $ids)->delete();
        return redirect()->route('raids.index')->with('success', 'Data razia yang dipilih berhasil dihapus.');
    }
}