<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class CandidatePict extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'candidatespict';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'employee_id',
        'pict_number',
        'pict_name',
    ];

    // Definisikan relasi banyak ke satu  
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'employee_id');
    }
}
