<?php

namespace App\Http\Controllers;

use App\Models\RekapIrs;
use Illuminate\Http\Request;

class KaprodiMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap status yang dipilih dari query string, default 'all'
        $statusFilter = $request->input('status', 'all');
        $searchQuery = $request->input('search', '');

        // Query dasar untuk mengambil data rekap IRS dengan relasi mahasiswa
        $rekapIrsQuery = RekapIrs::with('mahasiswa.wali');

        // Fitur pencarian berdasarkan nama mahasiswa
        if ($searchQuery) {
            $rekapIrsQuery->whereHas('mahasiswa', function($query) use ($searchQuery) {
                $query->where('namaMahasiswa', 'like', '%' . $searchQuery . '%');
            });
        }

        // Filter berdasarkan status jika statusFilter bukan 'all'
        if ($statusFilter !== 'all') {
            if ($statusFilter === 'disetujui') {
                $rekapIrsQuery->where('rekap_irs.status', 1);
            } elseif ($statusFilter === 'belum') {
                $rekapIrsQuery->whereNull('rekap_irs.status');
            } elseif ($statusFilter === 'tidak') {
                $rekapIrsQuery->where('rekap_irs.status', 0);
            }
        }

        // Ambil data rekap IRS dengan pagination
        $rekapIrs = $rekapIrsQuery->paginate(10);

        // Hitung jumlah mahasiswa berdasarkan status
        $allCount = RekapIrs::count();
        $disetujuiCount = RekapIrs::where('status', 1)->count();
        $belumDisetujuiCount = RekapIrs::whereNull('status')->count();
        $tidakDisetujuiCount = RekapIrs::where('status', 0)->count();

        // Kembalikan view dengan data yang diperlukan
        return view('kaprodi.mahasiswa', compact('rekapIrs', 'statusFilter', 'allCount', 'disetujuiCount', 'belumDisetujuiCount', 'tidakDisetujuiCount'));
    }
}
