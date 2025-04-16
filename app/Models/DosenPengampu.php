<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPengampu extends Model
{
    use HasFactory;

    protected $table = 'dosen_pengampu';

    // protected $primaryKey = ['kode_mata_kuliah', 'nip_dosen'];

    // public $incrementing = false;

    public $timestamps = false;

    
    protected $fillable = [
        'kode_mata_kuliah', 'nip_dosen',
    ];

    // Relasi dengan mata kuliah
    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_pengampu', 'nip_dosen', 'kode_mata_kuliah');
    }

    // Relasi dengan dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip_dosen', 'nip');
    }

    public function irs()
    {
        return $this->belongsToMany(IRS::class, 'dosen_pengampu', 'nip_dosen', 'kode_mata_kuliah', 'nip', 'kode_mata_kuliah');
    }
    
    

}

