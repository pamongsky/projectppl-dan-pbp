<?php

namespace Database\Seeders;
use App\Models\Ruangan;
use App\Models\ProgramStudi;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil program studi berdasarkan nama
        $prodiMatematika = ProgramStudi::where('namaProdi', 'Matematika')->first();
        $prodiFisika = ProgramStudi::where('namaProdi', 'Fisika')->first();
        $prodiKimia = ProgramStudi::where('namaProdi', 'Kimia')->first();
        $prodiInformatika = ProgramStudi::where('namaProdi', 'Informatika')->first();

        // Data ruangan untuk program studi Informatika
        $ruanganInformatika = [
            ['kodeRuang' => 'E101', 'namaRuang' => 'Ruang Kelas E101', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'E102', 'namaRuang' => 'Ruang Kelas E102', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'E103', 'namaRuang' => 'Ruang Kelas E103', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'K101', 'namaRuang' => 'Ruang Kelas K101', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'K102', 'namaRuang' => 'Ruang Kelas K102', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'K202', 'namaRuang' => 'Ruang Kelas K202', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'A303', 'namaRuang' => 'Ruang Kelas A303', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'E201', 'namaRuang' => 'Lab Komputer D', 'kapasitas' => 25, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'E202', 'namaRuang' => 'Lab Komputer B', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'E203', 'namaRuang' => 'Lab Komputer C', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
            ['kodeRuang' => 'A301', 'namaRuang' => 'Lab Komputer A', 'kapasitas' => 40, 'idProdi' => $prodiInformatika->id, 'status' => true],
        ];

        // Data ruangan program studi lain
        $ruanganLain = [
            ['kodeRuang' => 'A101', 'namaRuang' => 'Ruang Kelas A101', 'kapasitas' => 30, 'idProdi' => $prodiMatematika->id, 'status' => true],
            ['kodeRuang' => 'A102', 'namaRuang' => 'Ruang Kelas A102', 'kapasitas' => 25, 'idProdi' => $prodiMatematika->id, 'status' => true],
            ['kodeRuang' => 'A103', 'namaRuang' => 'Ruang Kelas A103', 'kapasitas' => 40, 'idProdi' => $prodiFisika->id, 'status' => true],
            ['kodeRuang' => 'K302', 'namaRuang' => 'Ruang Kelas K302', 'kapasitas' => 35, 'idProdi' => $prodiFisika->id, 'status' => false], // Ruangan ini tidak aktif
            ['kodeRuang' => 'B101', 'namaRuang' => 'Ruang Kelas B101', 'kapasitas' => 50, 'idProdi' => $prodiKimia->id, 'status' => true],
        ];

        // Insert semua data ke tabel ruangan
        Ruangan::insert(array_merge($ruanganInformatika, $ruanganLain));
    }
}