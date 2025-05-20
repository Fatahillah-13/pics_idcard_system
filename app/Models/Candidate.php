<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    use HasFactory;
    // Nama tabel yang terkait dengan model ini
    protected $table = 'candidates';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'employee_id',
        'name',
        'job_level',
        'department',
        'birthplace',
        'birthdate',
        'first_working_day',
    ];
    // Definisikan relasi satu ke satu  
    public function candidatepict()
    {
        return $this->hasOne(CandidatePict::class, 'employee_id');
    }
}
