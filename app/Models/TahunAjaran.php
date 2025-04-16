<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';  // Nama tabel
    // protected $primaryKey = 'id'; // Biasanya 'id' sebagai primary key default di Laravel
    // public $timestamps = true;  // Mengaktifkan timestamps

    // Kolom yang dapat diisi (fillable)
    protected $fillable =  ['namaThnAjaran'];
         // Format: Ganjil 2024/2025
    
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'idThnAjaran');
    }
}
