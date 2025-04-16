<?php
// Untuk seeder database
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'program_studi';

    // Tentukan field yang dapat diisi (mass assignable)
    protected $fillable = ['namaProdi', 'idFakultas'];
    protected $primaryKey = 'id';
    
    // Relasi ke Fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'idFakultas');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'idProdi');
    }
}
