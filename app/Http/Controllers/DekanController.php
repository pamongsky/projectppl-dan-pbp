<?php

namespace App\Http\Controllers;
use App\Models\Ruangan;
use App\Models\DaftarRuang;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DekanController extends Controller
{
    public function index()
    {
        // Mengambil data program studi dan menghitung jumlah ruangan yang digunakan oleh masing-masing prodi
        $daftarRuang = DB::table('program_studi')
        ->leftJoin('daftar_ruang', 'program_studi.id', '=', 'daftar_ruang.idProdi')
        ->leftJoin('ruangan', 'daftar_ruang.kodeRuang', '=', 'ruangan.kodeRuang')
        ->select(
            'program_studi.id as idProdi',
            'program_studi.namaProdi',
            DB::raw('COUNT(ruangan.kodeRuang) as jumlahRuangan'),
            DB::raw('COUNT(CASE WHEN ruangan.status = 1 THEN 1 END) as totalDisetujui'),
            DB::raw('COUNT(CASE WHEN ruangan.status = 0 THEN 1 END) as totalBelumDisetujui')
        )
        ->groupBy('program_studi.id', 'program_studi.namaProdi')
        ->get();

        return view('dekan.Druangan', compact('daftarRuang'));
    }
    
    
    // Menampilkan detail ruang berdasarkan kode prodi
    public function show($idProdi)
    {
        $ruangan = DaftarRuang::join('ruangan', 'daftar_ruang.kodeRuang', '=', 'ruangan.kodeRuang')
            ->join('program_studi', 'program_studi.id', '=', 'daftar_ruang.idProdi') // Mengambil data namaProdi dari program_studi
            ->where('daftar_ruang.idProdi', $idProdi)
            ->select('ruangan.kodeRuang', 'ruangan.namaRuang', 'ruangan.kapasitas','ruangan.status', 'daftar_ruang.jumlahRuangan', 'program_studi.namaProdi')
            ->get();
        
        return view('dekan.DdetailRuangan', compact('ruangan', 'idProdi'));
    }
    


    public function approveAll(Request $request)
    {
        $idProdi = $request->input('idProdi'); // Ambil idProdi dari request
    
        // Perbarui status semua ruangan dengan idProdi terkait menjadi "Disetujui" (status = 1)
        DB::table('ruangan')
            ->join('daftar_ruang', 'ruangan.kodeRuang', '=', 'daftar_ruang.kodeRuang')
            ->where('daftar_ruang.idProdi', $idProdi)
            ->update(['ruangan.status' => true]);
    
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('dekan.ruangan', ['idProdi' => $idProdi])
            ->with('success', 'Semua ruangan telah disetujui.');
    }

    public function rejectAll(Request $request)
    {
        $idProdi = $request->input('idProdi'); // Ambil idProdi dari request

        // Perbarui status semua ruangan dengan idProdi terkait menjadi "Belum Disetujui" (status = false)
        DB::table('ruangan')
            ->join('daftar_ruang', 'ruangan.kodeRuang', '=', 'daftar_ruang.kodeRuang')
            ->where('daftar_ruang.idProdi', $idProdi)
            ->update(['ruangan.status' => false]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('dekan.ruangan', ['idProdi' => $idProdi])
            ->with('success', 'Semua ruangan telah ditolak.');
    }

    public function showJadwalPerProdi()
    {
        $daftarProdi = ProgramStudi::all(); // Fetch all programs
        return view('dekan.Djadwal', compact('daftarProdi'));
    }
    

    
    public function detailJadwalProdi($idProdi)
    {
        
        // Log untuk memastikan $idProdi yang diterima
    Log::debug('Request received for detailJadwalProdi with idProdi: ' . $idProdi);

    try {
        // Query untuk mendapatkan data jadwal
        $jadwal = DB::table('jadwal')
            ->join('daftar_ruang', 'jadwal.kodeRuang', '=', 'daftar_ruang.kodeRuang')
            ->join('program_studi', 'daftar_ruang.idProdi', '=', 'program_studi.id')
            ->join('ruangan', 'jadwal.kodeRuang', '=', 'ruangan.kodeRuang')
            ->where('program_studi.id', $idProdi)
            // ->where('jadwal.status', false) // Uncomment if needed
            ->select(
                'jadwal.id',
                'jadwal.kode_mata_kuliah',
                'jadwal.hari',
                'jadwal.waktuMulai',
                'jadwal.waktuSelesai',
                'jadwal.kuota',
                'ruangan.kapasitas',
                'jadwal.kodeRuang'
            )
            ->get();

        // Log hasil query
        Log::debug('Jadwal data fetched: ' . $jadwal->toJson());

        if ($jadwal->isEmpty()) {
            Log::warning('No data found for program studi idProdi: ' . $idProdi);
        }

    } catch (\Exception $e) {
        // Log error jika query gagal
        Log::error('Error fetching jadwal for idProdi ' . $idProdi . ': ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data jadwal.');
    }

    // Kirim data ke view
    return view('dekan.Ddetailjadwal', compact('jadwal'));
}
    

    

}
