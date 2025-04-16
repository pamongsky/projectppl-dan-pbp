<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            ['user_id' => '24060122140101', 'role_id' => 1], // Mahasiswa
            ['user_id' => '197108111997001004', 'role_id' => 3], // Ketua Prodi
            // ['user_id' => '12345678910', 'role_id' => 1], // Admin 3 role
            ['user_id' => '12345678910', 'role_id' => 2],
            // ['user_id' => '12345678910', 'role_id' => 3], 
            // ['user_id' => '0123456789', 'role_id' => 5], 
            ['user_id' => '0123456789', 'role_id' => 4], 
            ['user_id'=> '9876543219', 'role_id'=> '5'],
        ]);
    }
}
