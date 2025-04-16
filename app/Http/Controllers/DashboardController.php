<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\RekapIrs;
use App\Models\IRS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function showDashboard($role)
    {
        $user = Auth::user();

        // Fetch role-specific data and return the correct view
        if ($role == 'mahasiswa') {
            $mahasiswa = Mahasiswa::with(['prodi', 'wali'])->where('nim', $user->id)->first();

            return view('dashboard.' . str_replace(' ', '_', $role), compact('mahasiswa'));
        }

        if ($role == 'pembimbing_akademik') {
            // Fetch any specific data for pembimbing_akademik
            return view('dashboard.' . str_replace(' ', '_', $role));
        }

        if ($role == 'ketua_prodi') {
            // Fetch any specific data for ketua_prodi
            return view('dashboard.' . str_replace(' ', '_', $role));
        }

        if ($role == 'bagian_akademik') {
            // Fetch any specific data for bagian_akademik
            return view('dashboard.' . str_replace(' ', '_', $role));
        }

        if ($role == 'dekan') {
            // Fetch any specific data for dekan
            return view('dashboard.' . str_replace(' ', '_', $role));
        }

        // If the role does not match, return a 404
        return abort(404);
    }


    public function mahasiswa()
    {
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->id)->first();
        return view('dashboard.mahasiswa', compact('mahasiswa'));
    }

    public function pembimbingAkademik()
    {
        return view('dashboard.pembimbing_akademik');
    }

    public function ketuaProdi()
    {
        return view('dashboard.ketua_prodi');
    }

    public function bagianAkademik()
    {
        Log::info("Rendering view: dashboard.bagian-akademik");
        return view('dashboard.bagian_akademik');
        
    }

    public function dekan()
    {
        return view('dashboard.dekan');
    }

    public function mahasiswaRegistrasi()
    {
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->id)->first();
        return view('mahasiswa.registrasi', compact('mahasiswa'));
    }

    public function mahasiswaAkademik()
    {
        // Ambil data mahasiswa berdasarkan NIM yang terautentikasi
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->id)->first();
        
        // Ambil data IRS berdasarkan mahasiswa yang terautentikasi
        $irs = IRS::with('jadwal.mataKuliah', 'jadwal.ruangan', 'jadwal.tahunAjaran', 'dosen')
                  ->where('nim', $mahasiswa->nim)
                  ->get();
    
        // Kelompokkan IRS berdasarkan semester
        $semesterGroups = $irs->groupBy('semester');
    
        $rekapIrs = RekapIrs::where('nim', $mahasiswa->nim)
        ->where('semester', $mahasiswa->semester)
        ->orderByDesc('created_at')
        ->first();

        // Cek apakah mahasiswa dapat melakukan perubahan IRS
        $canMakeChanges = $rekapIrs && $rekapIrs->status !== 'disetujui';
    
        // Kirimkan data ke view
        return view('mahasiswa.akademik', compact('mahasiswa', 'semesterGroups', 'rekapIrs', 'canMakeChanges'));
    }
    
    public function kaprodiMahasiswa()
    {
        return view('kaprodi.mahasiswa');
    }

    // public function kaprodiMataKuliah()
    // {
    //     return view('kaprodi.mata_kuliah');
    // }

    public function kaprodiJadwalKuliah()
    {
        return view('kaprodi.jadwal_kuliah');
    }

}
