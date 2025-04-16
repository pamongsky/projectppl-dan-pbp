<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\IRS;
use App\Models\TahunAjaran;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Dosen;
use Illuminate\Http\Request;

//ini masih belom bisa konek ke db buat kuotanya
class JadwalIRSController extends Controller
{
//    public function ambilKelas(Request $request, $jadwalId)
//    {
//        // Cari jadwal berdasarkan ID
//        $jadwal = Jadwal::findOrFail($jadwalId);
//        $ruangan = Ruangan::where('kodeRuang', $jadwal->kodeRuang)->first();
//    
//        // Cek apakah kuota sudah penuh
//        if ($jadwal->kuota >= $ruangan->kapasitas) {
//            return response()->json(['message' => 'Kuota penuh, tidak dapat mengambil kelas'], 400);
//        }
//    
//        // Tambahkan kuota
//        $jadwal->kuota += 1;
//        $jadwal->save();
//    
//        return response()->json(['message' => 'Berhasil mengambil kelas'], 200);
//    }
// //   

//    public function batalKelas(Request $request, $jadwalId)
//    {
//        // Cari jadwal berdasarkan ID
//        $jadwal = Jadwal::findOrFail($jadwalId);
//    
//        // Pastikan kuota tidak negatif
//        if ($jadwal->kuota > 0) {
//            $jadwal->kuota -= 1;
//            $jadwal->save();
//        }
//    
//        return response()->json(['message' => 'Berhasil membatalkan kelas'], 200);
//  //  }

//    public function cekKuota($jadwalId)
//    {
//        $jadwal = Jadwal::findOrFail($jadwalId);
//        $ruangan = Ruangan::where('kodeRuang', $jadwal->kodeRuang)->first();
//    
//        return response()->json([
//            'kuota_terisi' => $jadwal->kuota,
//            'kapasitas_ruangan' => $ruangan->kapasitas,
//            'tersedia' => $ruangan->kapasitas - $jadwal->kuota
//        ], 200);
//    }
// //   

public function addToIrs(Request $request)
{
    $jadwalId = $request->input('jadwal_id');
    $jadwal = Jadwal::find($jadwalId);

    // Cek apakah kuota penuh
    if ($jadwal->kuota_terisi >= $jadwal->kuota_total) {
        return response()->json([
            'status' => 'error',
            'message' => 'Kuota kelas sudah penuh!'
        ], 400);
    }

    // Tambahkan jadwal ke IRS mahasiswa
    IRS::create([
        'user_id' => auth()->id(),
        'jadwal_id' => $jadwalId
    ]);

    // Tambah kuota terisi
    $jadwal->increment('kuota_terisi');

    return response()->json([
        'status' => 'success',
        'message' => 'Kelas berhasil ditambahkan',
        'jadwal' => $jadwal
    ]);
}

public function removeFromIrs(Request $request)
{
    $jadwalId = $request->input('jadwal_id');
    $irs = IRS::where('user_id', auth()->id())
              ->where('jadwal_id', $jadwalId)
              ->first();

    if (!$irs) {
        return response()->json([
            'status' => 'error',
            'message' => 'Kelas tidak ditemukan di IRS Anda'
        ], 404);
    }

    $irs->delete();

    // Kurangi kuota terisi
    $jadwal = Jadwal::find($jadwalId);
    $jadwal->decrement('kuota_terisi');

    return response()->json([
        'status' => 'success',
        'message' => 'Kelas berhasil dihapus',
        'jadwal' => $jadwal
    ]);
}


}
