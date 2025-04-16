<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\IRS;
use App\Models\RekapIrs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;


class PembimbingAkademikController extends Controller
{
    // Halaman Perwalian
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', 'all');
        $search = $request->get('search', '');
        
        // Query data mahasiswa bimbingan
        $query = RekapIRS::whereHas('mahasiswa', function($q) use ($search) {
            $q->where('namaMahasiswa', 'like', "%$search%")
              ->orWhere('nim', 'like', "%$search%");
        });

        if ($statusFilter != 'all') {
            $query->where('status', $statusFilter == 'disetujui' ? 1 : ($statusFilter == 'belum' ? null : 0));
        }

        $rekapIrs = $query->paginate(10);

        return view('pa.perwalian', [
            'rekapIrs' => $rekapIrs,
            'statusFilter' => $statusFilter,
            'allCount' => RekapIRS::count(),
            'disetujuiCount' => RekapIRS::where('status', 1)->count(),
            'belumDisetujuiCount' => RekapIRS::whereNull('status')->count(),
            'tidakDisetujuiCount' => RekapIRS::where('status', 0)->count(),
        ]);
    }

    public function detail($id)
    {
        // Ambil data mahasiswa dan rekap IRS berdasarkan ID mahasiswa
        $mahasiswa = Mahasiswa::with('rekapIrs.tahunAjaran')->where('nim', $id)->first();
        
        // Kirim data ke view
        return view('pa.detailmahasiswa', compact('mahasiswa'));
    }

    public function detail2($id)
    {
        // Ambil data mahasiswa dan rekap IRS berdasarkan ID mahasiswa
        $mahasiswa = Mahasiswa::with('rekapIrs.tahunAjaran')->where('nim', $id)->first();
        
        // Ambil data IRS berdasarkan mahasiswa
        $irs = IRS::with('jadwal.mataKuliah', 'jadwal.ruangan', 'jadwal.tahunAjaran', 'dosen')
                  ->where('nim', $mahasiswa->nim)
                  ->get();
    
        // Kelompokkan IRS berdasarkan semester
        $semesterGroups = $irs->groupBy('semester');
        
        // Kirimkan data ke view
        return view('pa.detail', compact('mahasiswa', 'semesterGroups'));
    }
    

    public function cetakIRS($nim, $semester)
    {
        // Ambil data mahasiswa berdasarkan NIM
        $mahasiswa = Mahasiswa::where('nim', $nim)->with('programStudi')->first();
        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan');
        }
    
        // Ambil data IRS berdasarkan NIM dan semester
        $semesterGroups = IRS::with([
            'jadwal.mataKuliah',
            'jadwal.ruangan',
            'dosen',
            'jadwal.tahunAjaran',
        ])
        ->where('nim', $nim)
        ->where('semester', $semester)
        ->get()
        ->groupBy('semester');
    
        if (!$semesterGroups->has($semester)) {
            abort(404, 'Data IRS tidak ditemukan untuk NIM dan semester yang dimaksud.');
        }
    
        // Render view cetak IRS
        $pdf = Pdf::loadView('pa.cetak', [
            'mahasiswa' => $mahasiswa,
            'semester' => $semester,
            'semesterGroups' => $semesterGroups,
        ]);
    
        return $pdf->download("IRS_{$nim}_Semester_{$semester}.pdf");
    }
    
    public function validasiIrs(Request $request, $id, $status)
    {
        // Validasi status
        $allowedStatuses = ['disetujui', 'tidak disetujui'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->withErrors(['Status tidak valid.']);
        }
    
        // Cari data mahasiswa berdasarkan ID/NIM
        $mahasiswa = Mahasiswa::where('nim', $id)->first();
        if (!$mahasiswa) {
            return redirect()->back()->withErrors(['Mahasiswa tidak ditemukan.']);
        }
    
        // Update status pada rekap IRS
        $mahasiswa->rekapIrs->update(['status' => $status]);
    
        return redirect()->back()->with('success', 'Status berhasil diperbarui menjadi ' . $status);
    }

    public function updateStatus($id, $status)
    {
        // Temukan mahasiswa berdasarkan ID
        $rekapIrs = RekapIrs::where('nim', $id)->first();

        // Tentukan status baru berdasarkan parameter yang dikirim
        if ($rekapIrs) {
            if ($status == 'disetujui') {
                $rekapIrs->status = 1;
            } elseif ($status == 'tidak') {
                $rekapIrs->status = 0;
            } elseif ($status == 'belum') {
                $rekapIrs->status = null;
            }
            $rekapIrs->save();
        }

        

        // Redirect kembali ke halaman detail
        return redirect()->route('pa.perwalian', ['id' => $rekapIrs->id])->with('success', 'Status berhasil diperbarui');
    }

    public function ajuan(Request $request)
    {
        // Pencarian berdasarkan nama atau NIM mahasiswa
        $search = $request->get('search', '');

        // Mengambil data rekap IRS tanpa filter status
        $rekapIrs = RekapIrs::whereHas('mahasiswa', function($query) use ($search) {
                                $query->where('namaMahasiswa', 'like', '%'.$search.'%')
                                      ->orWhere('nim', 'like', '%'.$search.'%');
                            })
                            ->paginate(10);

        return view('pa.ajuanIRS', compact('rekapIrs'));
    }

}
