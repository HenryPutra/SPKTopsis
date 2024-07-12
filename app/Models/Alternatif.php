<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatif'; // Pastikan nama tabel di sini benar
    protected $fillable = [
        'kode',
        'alternatif',
    ];
    public function subkriteria()
    {
        return $this->hasMany(Subkriteria::class, 'alternatif_id', 'id');
    }
}
