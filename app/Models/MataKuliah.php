<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah'; // Nama tabel
    protected $primaryKey = 'kode_mata_kuliah';
    public $incrementing = false;
    // public $timestamp = false;
    protected $fillable = [
        'kode_mata_kuliah',
        'nama_mata_kuliah',
        'jumlah_sks',
        'semester',
        'jumlah_kelas',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
    public function dosenPengampu()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_pengampu', 'kode_mata_kuliah', 'nip_dosen');
    }
}
