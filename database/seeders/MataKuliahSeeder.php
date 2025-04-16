<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_mata_kuliah' => 'PAIK6103', 'nama_mata_kuliah' => 'Dasar Sistem', 'jumlah_sks' => 3, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6102', 'nama_mata_kuliah' => 'Dasar Pemrograman', 'jumlah_sks' => 3, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UNW00007', 'nama_mata_kuliah' => 'Bahasa Inggris', 'jumlah_sks' => 2, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6105', 'nama_mata_kuliah' => 'Struktur Diskrit', 'jumlah_sks' => 4, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6101', 'nama_mata_kuliah' => 'Matematika I', 'jumlah_sks' => 2, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6104', 'nama_mata_kuliah' => 'Logika Informatika', 'jumlah_sks' => 3, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UNW00003', 'nama_mata_kuliah' => 'Pancasila dan Kewarganegaraan', 'jumlah_sks' => 3, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UNW00005', 'nama_mata_kuliah' => 'Olah Raga', 'jumlah_sks' => 1, 'semester' => 1, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6203', 'nama_mata_kuliah' => 'Organisasi dan Arsitektur', 'jumlah_sks' => 3, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6202', 'nama_mata_kuliah' => 'Algoritma dan Pemrograman', 'jumlah_sks' => 4, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UNW00004', 'nama_mata_kuliah' => 'Bahasa Indonesia', 'jumlah_sks' => 2, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UNW00006', 'nama_mata_kuliah' => 'Internet of Things', 'jumlah_sks' => 2, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6201', 'nama_mata_kuliah' => 'Matematika II', 'jumlah_sks' => 2, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6204', 'nama_mata_kuliah' => 'Aljabar Linier', 'jumlah_sks' => 3, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'UUW00001', 'nama_mata_kuliah' => 'Pendidikan Agama', 'jumlah_sks' => 2, 'semester' => 2, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6302', 'nama_mata_kuliah' => 'Sistem Operasi', 'jumlah_sks' => 3, 'semester' => 3, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6301', 'nama_mata_kuliah' => 'Struktur Data', 'jumlah_sks' => 4, 'semester' => 3, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6305', 'nama_mata_kuliah' => 'Interaksi Manusia-Komputer', 'jumlah_sks' => 3, 'semester' => 3, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6303', 'nama_mata_kuliah' => 'Basis Data', 'jumlah_sks' => 4, 'semester' => 3, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6304', 'nama_mata_kuliah' => 'Metode Numerik', 'jumlah_sks' => 3, 'semester' => 3, 'jumlah_kelas' => 4],
            ['kode_mata_kuliah' => 'PAIK6306', 'nama_mata_kuliah' => 'Statistika', 'jumlah_sks' => 3, 'semester' => 3, 'jumlah_kelas' => 4],
        ];

        DB::table('mata_kuliah')->insert($data);
    }
}