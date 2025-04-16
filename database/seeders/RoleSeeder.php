<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Pembimbing Akademik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Ketua Prodi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Bagian Akademik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Dekan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
