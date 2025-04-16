<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'fakultas';

    // Tentukan field yang dapat diisi (mass assignable)
    protected $fillable = ['namaFakultas'];

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class, 'idFakultas');
    }
}
