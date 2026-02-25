<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'department';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'department_name',
    ];
}
