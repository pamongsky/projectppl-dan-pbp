<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Faker\Factory as Faker;

class MahasiswaDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $nipWali = Dosen::where('nip', '12345678910')->first();

        foreach (range(1, 20) as $index) {
            Mahasiswa::create([
                'nim' => $faker->unique()->numerify('2406012#######'), // NIM unik
                'namaMahasiswa' => $faker->name, // Nama mahasiswa
                'NIPWali' => $nipWali->nip, // NIP Wali tertentu
                'tahunAngkatan' => $faker->year('now'), // Tahun angkatan
                'semester' => $faker->numberBetween(1, 8), // Semester acak antara 1-8
                'idProdi' => 4, // ID Prodi, misalnya 1 (pastikan prodi ada di database)
                'IPk' => $faker->randomFloat(2, 2.0, 4.0), // IPK acak antara 2.0 dan 4.0
                'status' => $faker->randomElement(['aktif', 'cuti', 'belum_dipilih']), // Status bervariasi
            ]);
        }
    }
}
