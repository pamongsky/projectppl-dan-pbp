<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TahunAjaran;
use App\Models\Ruangan;
use App\Models\MataKuliah; 
use App\Models\Jadwal;
use App\Models\DosenPengampu;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\RekapIrs;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('dashboard.ketua_prodi', function ($view) {
            // Mengambil jumlah mahasiswa, mata kuliah, dan jadwal kuliah
            $jumlahMahasiswa = Mahasiswa::count();
            $jumlahMataKuliah = MataKuliah::count();
            $jumlahJadwalKuliah = Jadwal::count();

            // Membagikan data ke view
            $view->with(compact('jumlahMahasiswa', 'jumlahMataKuliah', 'jumlahJadwalKuliah'));
        });
        
        // Membagikan data ke semua view yang membutuhkan
        View::composer('kaprodi.jadwal_kuliah', function ($view) {
            $tahunAjarans = TahunAjaran::all();
            $ruangans = Ruangan::all();
            $mataKuliahs = MataKuliah::all();
            $jadwals = Jadwal::with(['tahunAjaran', 'mataKuliah', 'ruangan'])->get();
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $dosenPengampu = DosenPengampu::with('mataKuliah', 'dosen')->get();
            $dosens = Dosen::all();

            // Memetakan mata kuliah dengan dosen pengampu (nip_dosen)
            $mataKuliahDosen = [];

            foreach ($mataKuliahs as $mataKuliah) {
                // Mendapatkan dosen pengampu untuk setiap mata kuliah
                $mataKuliahDosen[$mataKuliah->kode_mata_kuliah] = $mataKuliah->dosenPengampu()->pluck('nip_dosen')->toArray();
            }

            // Mengirimkan data ke view
            $view->with(compact('tahunAjarans', 'ruangans', 'mataKuliahs', 'jadwals', 'days', 'dosenPengampu', 'dosens', 'mataKuliahDosen'));
        });

        // Menyuntikkan data ke view pembimbing_akademik
        View::composer('dashboard.pembimbing_akademik', function ($view) {
            // Ambil user yang sedang login
            $user = Auth::user();

            // Jika tidak ada user yang login, kita bisa menghandle dengan cara lain, misalnya redirect ke login
            if (!$user) {
                return redirect()->route('login');
            }

            // Ambil data mahasiswa yang dibimbing oleh user (berdasarkan NIP)
            $nip = $user->id; // Menggunakan NIP yang ada di Auth::user()

            // Ambil mahasiswa aktif yang memiliki NIPWali yang sama dengan NIP user
            $mahasiswaAktif = Mahasiswa::where('status', 'aktif')
                ->where('NIPWali', $nip)
                ->get();

            // Ambil mahasiswa yang IRS-nya sudah disetujui
            $mahasiswaDisetujui = RekapIrs::where('status', true)
                ->whereIn('nim', $mahasiswaAktif->pluck('nim'))
                ->get();

            // Hitung jumlah mahasiswa aktif dan disetujui
            $jumlahMahasiswaAktif = $mahasiswaAktif->count();
            $jumlahMahasiswaDisetujui = $mahasiswaDisetujui->count();

            // Hitung persentase IRS yang disetujui
            $persentaseDisetujui = $jumlahMahasiswaAktif > 0 ? ($jumlahMahasiswaDisetujui / $jumlahMahasiswaAktif) * 100 : 0;
            
            // Kirimkan data ke view
            $view->with([
                'user' => $user,
                'jumlahMahasiswaAktif' => $jumlahMahasiswaAktif,
                'jumlahMahasiswaDisetujui' => $jumlahMahasiswaDisetujui,
                'persentaseDisetujui' => $persentaseDisetujui,
            ]);
        });

        View::composer('pa.perwalian', function ($view) {
            // Ambil user yang sedang login
            $user = Auth::user();
        
            // Jika tidak ada user yang login, kita bisa menghandle dengan cara lain, misalnya redirect ke login
            if (!$user) {
                return redirect()->route('login');
            }
        
            // Ambil NIP dari user yang sedang login
            $nip = $user->id; // Menggunakan NIP yang ada di Auth::user()
        
            // Ambil mahasiswa yang sedang aktif dan dibimbing oleh NIPWali yang sama dengan NIP user
            $mahasiswaAktif = Mahasiswa::where('status', 'aktif')
                ->where('NIPWali', $nip)
                ->get();
        
            // Ambil mahasiswa yang IRS-nya sudah disetujui
            $mahasiswaDisetujui = RekapIrs::where('status', true)
                ->whereIn('nim', $mahasiswaAktif->pluck('nim'))
                ->get();
        
            // Hitung jumlah mahasiswa aktif dan disetujui
            $jumlahMahasiswaAktif = $mahasiswaAktif->count();
            $jumlahMahasiswaDisetujui = $mahasiswaDisetujui->count();
        
            // Hitung persentase IRS yang disetujui
            $persentaseDisetujui = $jumlahMahasiswaAktif > 0 ? ($jumlahMahasiswaDisetujui / $jumlahMahasiswaAktif) * 100 : 0;
        
            // Ambil data mahasiswa dengan relasi rekapIrs dan tahunAjaran
            $mahasiswa = Mahasiswa::with('rekapIrs.tahunAjaran')
                ->where('status', 'aktif') // hanya mahasiswa yang aktif
                ->whereIn('nim', $mahasiswaAktif->pluck('nim')) // filter berdasarkan nim mahasiswa yang dibimbing
                ->get();
        
            // Kirimkan data ke view
            $view->with([
                'user' => $user,
                'jumlahMahasiswaAktif' => $jumlahMahasiswaAktif,
                'jumlahMahasiswaDisetujui' => $jumlahMahasiswaDisetujui,
                'persentaseDisetujui' => $persentaseDisetujui,
                'mahasiswa' => $mahasiswa, // Mahasiswa yang aktif dan relevan untuk perwalian
            ]);
        });

        View::composer('kaprodi.mahasiswa', function ($view) {
            // You can add any global status-related logic here if needed
            $view->with('statusLabels', $this->statusLabels());
        });
    }

    /**
     * Define a helper function for status logic
     */
    protected function statusLabels()
    {
        // Define a helper method to interpret status
        return [
            true => 'Disetujui',
            false => 'Tidak Disetujui',
            null => 'Belum Disetujui',
        ];
    }

}
