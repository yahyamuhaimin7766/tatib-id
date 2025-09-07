<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts; // Menggunakan fitur update or create

class StudentsImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'nama' => $row['nama'],
            'kelas' => $row['kelas'],
            'nis' => $row['nis'] ?? null, // Ambil NIS dari excel jika ada
            'total_point' => 0, // Set point awal ke 0
        ]);
    }

    /**
     * Tentukan kolom unik untuk mencari data yang sudah ada.
     */
    public function uniqueBy()
    {
        return ['nama', 'kelas'];
    }
}