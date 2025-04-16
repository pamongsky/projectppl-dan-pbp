<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'nim' => '24060122140101',
                'namaMahasiswa' => 'Zahidan Aqila',
                'NIPWali' => null, // Jika tidak ada wali, bisa diisi null
                'tahunAngkatan' => 2022,
                'semester' => 3,
                'idProdi' => 1, // Ganti dengan ID prodi yang sesuai
                'IPk' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
          
        ]);
    }
}