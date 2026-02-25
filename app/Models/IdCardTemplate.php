<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardTemplate extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'card_template';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'department',
        'joblevel',
        'ctpat',
        'image_path', // Assuming this is the column for the file path
    ];
}
