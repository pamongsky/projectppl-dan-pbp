<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index($nim)
    {
        $nim = Auth::user()->id; 
        $mahasiswa = Mahasiswa::where('nim', $nim)->first(); 
        $mataKuliah = MataKuliah::all();
        return view('mahasiswa.index', compact('mahasiswa', 'mataKuliah'));
    }

    public function jadwal(Request $request)
    {
        $jadwal = Jadwal::whereIn('kode_mata_kuliah', $request->mata_kuliah)->get();
        return view('mahasiswa.jadwal', compact('jadwal'));
    }

    public function mahasiswaIRS()
    {
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->id)->first();
        return view('mahasiswa.isi_irs', compact('mahasiswa'));
    }

    public function updateStatus(Request $request)
    {
        $nim = $request->input('nim');
        $status = $request->input('status'); // Status bisa 1 (Aktif) atau 0 (Cuti)
    
        try {
            $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        
            if (!$mahasiswa) {
                return response()->json(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan.']);
            }
        
            // Update status mahasiswa
            $mahasiswa->status = $status;
            $mahasiswa->save();
        
            return response()->json(['status' => 'success', 'message' => 'Status berhasil diubah.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan.']);
        }
    }

}
