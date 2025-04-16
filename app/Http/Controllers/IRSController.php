<?php
// app/Http/Controllers/IRSController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IRS;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use App\Models\RekapIrs;
use App\Models\Jadwal; // Make sure to import your IRS model
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class IRSController extends Controller
{

    

    public function cetakIrs($semester)
    {
        // Ambil data IRS berdasarkan semester yang dipilih
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->id)->first();
        $irs = IRS::with(['jadwal.mataKuliah', 'jadwal.ruangan', 'jadwal.tahunAjaran', 'dosen'])
                  ->where('nim', $mahasiswa->nim)
                  ->where('semester', $semester)
                  ->get();

        // Kelompokkan IRS berdasarkan semester
        $semesterGroups = $irs->groupBy('semester');

        // Generate PDF
        $pdf = PDF::loadView('mahasiswa.cetakIRS', compact('mahasiswa', 'semesterGroups'));

        // Return PDF sebagai response untuk diunduh
        return $pdf->download('IRS_Semester_'.$semester.'.pdf');
    }

    

    public function saveIRS(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'courses' => 'required|array',
            'courses.*.idJadwal' => 'required|exists:jadwal,id',
            'courses.*.kode_mata_kuliah' => 'required|string',
            'courses.*.idThnAjaran' => 'required|exists:tahun_ajaran,id',
            'semester' => 'required|integer',
            'nim' => 'required|exists:mahasiswa,nim',
            'courses.*.idProdi' => 'required|exists:program_studi,id',
        ]);
    
        // Log::debug('Data yang diterima: ', $request->all());
    
        try {
            // Ambil 'idThnAjaran' dari item pertama di array 'courses'
            $idThnAjaran = $validated['courses'][0]['idThnAjaran'];
    
            // Cek apakah ada data IRS lama berdasarkan NIM dan idThnAjaran
            $existingIRS = IRS::where('nim', $validated['nim'])
                // ->where('idThnAjaran', $idThnAjaran)
                ->where('semester', $validated['semester'])
                ->get();
    
            if ($existingIRS->isNotEmpty()) {
                // Kurangi kuota untuk data IRS lama
                foreach ($existingIRS as $irs) {
                    Jadwal::where('id', $irs->idJadwal)->decrement('kuota', 1);
                }
    
                // Hapus data IRS lama
                IRS::where('nim', $validated['nim'])
                    // ->where('idThnAjaran', $idThnAjaran)
                    ->where('semester', $validated['semester'])
                    ->delete();
    
                // Log::info('Data IRS lama berhasil dihapus untuk NIM: ' . $validated['nim']);
            }
    
            // Simpan data IRS baru
            $totalSKS = 0;
            foreach ($validated['courses'] as $course) {
                IRS::create([
                    'idJadwal' => $course['idJadwal'],
                    'kode_mata_kuliah' => $course['kode_mata_kuliah'],
                    'nim' => $validated['nim'],
                    'idThnAjaran' => $course['idThnAjaran'], // Diambil dari setiap item 'courses'
                    'semester' => $validated['semester'],
                ]);
    
                // Tambahkan kuota untuk jadwal baru
                Jadwal::where('id', $course['idJadwal'])->increment('kuota', 1);
                
                $mataKuliah = MataKuliah::where('kode_mata_kuliah', $course['kode_mata_kuliah'])->first();
                if ($mataKuliah) {
                    $totalSKS += $mataKuliah->jumlah_sks;
                }
            }

            // Update atau buat data rekap_irs
            RekapIrs::updateOrCreate(
                ['nim' => $validated['nim'], 'idThnAjaran' => '1'],
                [
                    'semester' => $validated['semester'],
                    'totalSKS' => $totalSKS,
                    'status' => 'belum disetujui',  // Status bisa disesuaikan dengan kebutuhan
                ]
            );

            Log::info('Data Rekap IRS', [
                'nim' => $validated['nim'],
                'idThnAjaran' => '1',
                'semester' => $validated['semester'],
                'totalSKS' => $totalSKS,
            ]);
            
    
            return response()->json(['message' => 'Data IRS berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan IRS: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan IRS.'], 500);
        }
    }
    

    public function perubahanIRS()
{

    return view('mahasiswa.perubahanIRS');
}


// Controller: IRSController.php
public function getIRSData(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'nim' => 'required|string',
        'semester' => 'required|integer',
    ]);

    // Ambil data IRS berdasarkan NIM dan Semester
    $irsData = IRS::where('nim', $validatedData['nim'])
                 ->where('semester', $validatedData['semester'])
                 ->with('mataKuliah', 'jadwal') // Misalnya relasi dengan model MataKuliah dan Jadwal
                 ->get();

    // Jika tidak ada data IRS, kembalikan array kosong
    if ($irsData->isEmpty()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Tidak ada data IRS untuk semester ini.',
            'data' => []
        ]);
    }

    // Jika ada data IRS, kembalikan data dalam format yang dapat digunakan di frontend
    $courseListData = [];
    foreach ($irsData as $irs) {
        $courseListData[] = [
            'kode_mata_kuliah' => $irs->kode_mata_kuliah,
            'nama_mata_kuliah' => $irs->mataKuliah->nama_mata_kuliah,
            'jumlah_sks' => $irs->mataKuliah->jumlah_sks,
            'semester' => $irs->semester,
            'jadwal' => $irs->jadwal,  // Ambil jadwal terkait
        ];
    }

    return response()->json([
        'status' => 'success',
        'data' => $courseListData,
    ]);
}
}
