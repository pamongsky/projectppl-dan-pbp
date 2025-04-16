<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapIrs extends Model
{
    use HasFactory;

    protected $table = 'rekap_irs';

    protected $fillable = [
        'nim',
        'idThnAjaran',
        'semester',
        'totalSKS',
        'status',
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'idThnAjaran');
    }

    
}
