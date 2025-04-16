<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['namaMahasiswa', 'nim', 'semester'];
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';


    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'idProdi', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'idProdi', 'id');
    }

    public function wali()
    {
        return $this->belongsTo(Dosen::class, 'NIPWali','nip');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function rekapIrs()
    {
        return $this->hasOne(RekapIrs::class, 'nim', 'nim');
    }
}
