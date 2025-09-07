<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kelas', 'nis', 'total_point'
    ];

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }

    public function lateArrivals()
    {
        return $this->hasMany(LateArrival::class);
    }

    // Update total point ketika ada pelanggaran baru
    public function updateTotalPoint()
    {
        $this->total_point = $this->violations()->sum('point');
        $this->save();
    }
}