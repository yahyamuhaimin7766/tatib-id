<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'pelanggaran', 'point', 'tanggal_waktu', 'input_by'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
