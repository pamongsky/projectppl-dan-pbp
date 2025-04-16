<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class IRS extends Model
{
    protected $table = 'irs';

    public $timestamps = false;

    protected $fillable = [
        'nim',
        'kode_mata_kuliah',
        'idJadwal',
        'idThnAjaran',
        'semester'
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'idJadwal');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'idThnAjaran');
    }

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_pengampu', 'kode_mata_kuliah', 'nip_dosen', 'kode_mata_kuliah', 'nip');
    }
    
}