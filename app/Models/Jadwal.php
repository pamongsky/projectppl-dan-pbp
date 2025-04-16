<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'idThnAjaran', 
        'kode_mata_kuliah', 
        'hari', 
        'waktuMulai', 
        'waktuSelesai', 
        'kelas', 
        'kodeRuang', 
        'status',
        'kuota'
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kodeRuang', 'kodeRuang');
    }

    // Relasi ke tabel tahun_ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'idThnAjaran');
    }
}