<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria'; // Pastikan nama tabel di sini benar
    protected $fillable = [
        'kode_kriteria',
        'kriteria',
        'nama_kriteria',
        'tipe_kriteria',
        'bobot',
    ];

    // Define the inverse relationship with Alternatif
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id', 'id');
    }

    // Define the relationship with Kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id');
    }
}
