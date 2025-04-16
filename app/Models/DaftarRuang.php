<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarRuang extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'daftar_ruang'; // Menyesuaikan nama tabel dengan konvensi Laravel

    // Tentukan primary key
    protected $primaryKey = 'id';

    public $timestamps = false;

    // Tentukan field yang dapat diisi
    protected $fillable = [
        'idProdi',
        'kodeRuang',
        'jumlahRuangan',
    ];
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'idProdi');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kodeRuang');
    }
}

