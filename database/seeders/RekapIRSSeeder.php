<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RekapIRS;
use App\Models\Mahasiswa;
use Faker\Factory as Faker;

class RekapIRSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil 20 mahasiswa yang memiliki NIPWali = '12345678910'
        $mahasiswa = Mahasiswa::where('NIPWali', '12345678910')->get();

        // Buat 20 data rekap_irs untuk mahasiswa yang diambil
        foreach ($mahasiswa as $index => $mhs) {
            RekapIRS::create([
                'nim' => $mhs->nim, // Menghubungkan dengan mahasiswa
                'idThnAjaran' => 2, // ID Tahun Ajaran yang tetap
                'semester' => $faker->numberBetween(1, 8), // Semester acak antara 1 dan 8
                'totalSKS' => $faker->numberBetween(18, 24), // Total SKS acak antara 18 hingga 24
                'status' => $faker->randomElement([true, false]), // Status disetujui (true) atau tidak disetujui (false)
            ]);
        }
    }
}
