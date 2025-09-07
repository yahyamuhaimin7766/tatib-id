<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'tanggal_waktu', 'keterangan'
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}