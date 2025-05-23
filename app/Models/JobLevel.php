<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobLevel extends Model
{
    use HasFactory;
    // Nama tabel yang terkait dengan model ini
    protected $table = 'joblevel';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'level_name',
    ];
}
