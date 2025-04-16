<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunAjaran::create(['namaThnAjaran' => 'Ganjil 2024/2025']);
        TahunAjaran::create(['namaThnAjaran' => 'Genap 2024/2025']);
        TahunAjaran::create(['namaThnAjaran' => 'Ganjil 2025/2026']);
        TahunAjaran::create(['namaThnAjaran' => 'Genap 2025/2026']);
        TahunAjaran::create(['namaThnAjaran' => 'Ganjil 2023/2024']);
        TahunAjaran::create(['namaThnAjaran' => 'Genap 2023/2024']);
    }
}
