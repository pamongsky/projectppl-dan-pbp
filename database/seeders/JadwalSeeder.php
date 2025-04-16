<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\TahunAjaran;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Dosen;

class JadwalSeeder extends Seeder
{
    public function run()
    {

        $jadwal = [
            // PAIK6103 - Dasar Sistem
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6103', 'hari' => 'Senin', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:30:00', 'kelas' => 'A', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6103', 'hari' => 'Selasa', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:30:00', 'kelas' => 'B', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6103', 'hari' => 'Rabu', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:30:00', 'kelas' => 'C', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6103', 'hari' => 'Kamis', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:30:00', 'kelas' => 'D', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6102 - Dasar Pemrograman
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6102', 'hari' => 'Senin', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:30:00', 'kelas' => 'A', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6102', 'hari' => 'Selasa', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:30:00', 'kelas' => 'B', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6102', 'hari' => 'Rabu', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:30:00', 'kelas' => 'C', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6102', 'hari' => 'Kamis', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:30:00', 'kelas' => 'D', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // UNW00007 - Bahasa Inggris
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00007', 'hari' => 'Senin', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:30:00', 'kelas' => 'A', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00007', 'hari' => 'Selasa', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:30:00', 'kelas' => 'B', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00007', 'hari' => 'Rabu', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:30:00', 'kelas' => 'C', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00007', 'hari' => 'Kamis', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:30:00', 'kelas' => 'D', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6105 - Struktur Diskrit
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6105', 'hari' => 'Senin', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:50:00', 'kelas' => 'A', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6105', 'hari' => 'Selasa', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'B', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6105', 'hari' => 'Rabu', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'C', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6105', 'hari' => 'Kamis', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'D', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

             // PAIK6101 - Matematika I
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6101', 'hari' => 'Jumat', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:40:00', 'kelas' => 'A', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6101', 'hari' => 'Jumat', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:40:00', 'kelas' => 'B', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6101', 'hari' => 'Jumat', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:40:00', 'kelas' => 'C', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6101', 'hari' => 'Jumat', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:40:00', 'kelas' => 'D', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
 
             // PAIK6104 - Logika Informatika
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6104', 'hari' => 'Senin', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:50:00', 'kelas' => 'A', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6104', 'hari' => 'Selasa', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'B', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6104', 'hari' => 'Rabu', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'C', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6104', 'hari' => 'Kamis', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'D', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
 
             // UNW00003 - Pancasila dan Kewarganegaraan
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00003', 'hari' => 'Senin', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'A', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00003', 'hari' => 'Selasa', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'B', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00003', 'hari' => 'Rabu', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'C', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00003', 'hari' => 'Kamis', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:50:00', 'kelas' => 'D', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
 
             // UNW00005 - Olah Raga
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00005', 'hari' => 'Jumat', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '08:50:00', 'kelas' => 'A', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00005', 'hari' => 'Jumat', 'waktuMulai' => '09:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'B', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00005', 'hari' => 'Jumat', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '10:50:00', 'kelas' => 'C', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
             ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'UNW00005', 'hari' => 'Jumat', 'waktuMulai' => '11:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'D', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

              // PAIK6302 - Sistem Operasi
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6302', 'hari' => 'Senin', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'A', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6302', 'hari' => 'Senin', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'B', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6302', 'hari' => 'Senin', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'C', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6302', 'hari' => 'Senin', 'waktuMulai' => '15:00:00', 'waktuSelesai' => '16:50:00', 'kelas' => 'D', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6301 - Struktur Data
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6301', 'hari' => 'Selasa', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '10:40:00', 'kelas' => 'A', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6301', 'hari' => 'Selasa', 'waktuMulai' => '11:00:00', 'waktuSelesai' => '13:40:00', 'kelas' => 'B', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6301', 'hari' => 'Selasa', 'waktuMulai' => '14:00:00', 'waktuSelesai' => '16:40:00', 'kelas' => 'C', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6301', 'hari' => 'Rabu', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '10:40:00', 'kelas' => 'D', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6305 - Interaksi Manusia-Komputer
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6305', 'hari' => 'Rabu', 'waktuMulai' => '11:00:00', 'waktuSelesai' => '12:50:00', 'kelas' => 'A', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6305', 'hari' => 'Rabu', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'B', 'kodeRuang' => 'E103', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6305', 'hari' => 'Kamis', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '09:50:00', 'kelas' => 'C', 'kodeRuang' => 'K101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6305', 'hari' => 'Kamis', 'waktuMulai' => '10:00:00', 'waktuSelesai' => '11:50:00', 'kelas' => 'D', 'kodeRuang' => 'K102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6303 - Basis Data
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6303', 'hari' => 'Kamis', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '15:40:00', 'kelas' => 'A', 'kodeRuang' => 'K202', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6303', 'hari' => 'Jumat', 'waktuMulai' => '08:00:00', 'waktuSelesai' => '10:40:00', 'kelas' => 'B', 'kodeRuang' => 'A303', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6304 - Metode Numerik
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6304', 'hari' => 'Jumat', 'waktuMulai' => '11:00:00', 'waktuSelesai' => '12:50:00', 'kelas' => 'A', 'kodeRuang' => 'E101', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],

            // PAIK6306 - Statistika
            ['idThnAjaran' => 1, 'kode_mata_kuliah' => 'PAIK6306', 'hari' => 'Jumat', 'waktuMulai' => '13:00:00', 'waktuSelesai' => '14:50:00', 'kelas' => 'A', 'kodeRuang' => 'E102', 'kuota' => 0, 'kapasitas' => 40, 'idProdi' => 4],
        ];

        DB::table('jadwal')->insert($jadwal);
                
    }

}

