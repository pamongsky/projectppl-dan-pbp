<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan program studi di Fakultas Sains dan Matematika
        $fakultas = \App\Models\Fakultas::where('namaFakultas', 'Fakultas Sains dan Matematika')->first();

        ProgramStudi::create(['namaProdi' => 'Matematika', 'idFakultas' => $fakultas->id]);
        ProgramStudi::create(['namaProdi' => 'Fisika', 'idFakultas' => $fakultas->id]);
        ProgramStudi::create(['namaProdi' => 'Kimia', 'idFakultas' => $fakultas->id]);
        ProgramStudi::create(['namaProdi' => 'Informatika', 'idFakultas' => $fakultas->id]);

        }
}
