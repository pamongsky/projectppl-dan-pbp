<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil id Prodi dari Program Studi
        $prodiMatematika = ProgramStudi::where('namaProdi', 'Matematika')->first();
        $prodiFisika = ProgramStudi::where('namaProdi', 'Fisika')->first();
        $prodiKimia = ProgramStudi::where('namaProdi', 'Kimia')->first();
        $prodiInformatika = ProgramStudi::where('namaProdi', 'Informatika')->first();

        // Menambahkan dosen untuk setiap program studi
        Dosen::create([
            'nip' => '1234567890',
            'namaDosen' => 'Dr. Ahmad S.Mat., M.Sc',
            'idProdi' => $prodiMatematika->id,
        ]);

        Dosen::create([
            'nip' => '2345678901',
            'namaDosen' => 'Prof. Siti S.Si.',
            'idProdi' => $prodiFisika->id,
        ]);

        Dosen::create([
            'nip' => '3456789012',
            'namaDosen' => 'Dr. Budi S.Si., M.Sc',
            'idProdi' => $prodiKimia->id,
        ]);

        Dosen::create([
            'nip' => '4567890123',
            'namaDosen' => 'Dr. Dian S.T., M.Kom',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198502010101001',
            'namaDosen' => 'Dr. Andi Setiawan',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '197601151002003',
            'namaDosen' => 'Prof. Dedi Kurniawan',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198010301202004',
            'namaDosen' => 'Dr. Siti Aminah',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198705161003005',
            'namaDosen' => 'Ir. Budi Santoso',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198908120201006',
            'namaDosen' => 'Dr. Farhan Hidayat',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '199202041201007',
            'namaDosen' => 'M. Rudi Prasetyo',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '197401051001008',
            'namaDosen' => 'Prof. Wawan Suryadi',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198305061201009',
            'namaDosen' => 'Dr. Laila Sofia',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198102040301010',
            'namaDosen' => 'Dr. Anton Supriyadi',
            'idProdi' => $prodiInformatika->id,
        ]);

        Dosen::create([
            'nip' => '198912160102011',
            'namaDosen' => 'Dr. Nina Ramadhani',
            'idProdi' => $prodiInformatika->id,
        ]);

    }
}
