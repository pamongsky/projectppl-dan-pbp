<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'dosen';

    protected $primaryKey = 'nip';

    // Tentukan field yang dapat diisi (mass assignable)
    protected $fillable = ['nip', 'namaDosen', 'idProdi'];

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'idProdi');
    }

    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_pengampu', 'nip_dosen', 'kode_mata_kuliah');
    }

    public function dosenPengampu()
    {
        return $this->hasMany(DosenPengampu::class, 'nip_dosen');
    }

    public function irs()
    {
        return $this->belongsToMany(IRS::class, 'dosen_pengampu', 'nip_dosen', 'kode_mata_kuliah', 'nip', 'kode_mata_kuliah');
    }

}
