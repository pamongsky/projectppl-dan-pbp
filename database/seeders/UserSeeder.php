<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['id' => '24060122140101', 'name' => 'Zahidan Aqila', 'password' => Hash::make('p123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => '197108111997001004', 'name' => 'Dosen A', 'password' => Hash::make('p123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => '12345678910', 'name' => 'Admin', 'password' => Hash::make('p123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => '0123456789', 'name' => 'BagianAkademik', 'password' => Hash::make('p123'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => '9876543219', 'name' => 'Dr. Panduwinata', 'password' => Hash::make('p123'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
