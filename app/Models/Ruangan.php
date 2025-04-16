<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'ruangan';

    // Tentukan primary key dan tipe data untuk primary key
    protected $primaryKey = 'kodeRuang';
    protected $keyType = 'string';
    public $incrementing = false; // Karena kodeRuang bukan auto-incrementing

    // Tentukan field yang dapat diisi (mass assignable)
    protected $fillable = [
        'kodeRuang',
        'namaRuang',
        'kapasitas',
        'idProdi',
        'status',
    ];
    // Tentukan bahwa tabel ini tidak menggunakan timestamps
    public $timestamps = false;

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'idProdi');
    }

    // Relasi ke Jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kodeRuang', 'kodeRuang');
    }

    // Relasi ke Daftar Ruang
    public function daftarRuang()
    {
        return $this->hasMany(DaftarRuang::class, 'kodeRuang', 'kodeRuang');
    }
    
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kodeRuang', 'kodeRuang');
    }
}


