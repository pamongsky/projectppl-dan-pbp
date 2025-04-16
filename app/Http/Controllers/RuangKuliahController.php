<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\DaftarRuang;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RuangKuliahController extends Controller
{
    // Menampilkan daftar ruang yang digunakan oleh program studi
    public function index()
    {
        // Mengambil data program studi dan menghitung jumlah ruangan yang digunakan oleh masing-masing prodi
        $daftarRuang = DB::table('program_studi')
            ->leftJoin('daftar_ruang', 'program_studi.id', '=', 'daftar_ruang.idProdi')
            ->leftJoin('ruangan', 'daftar_ruang.kodeRuang', '=', 'ruangan.kodeRuang')
            ->select(
                'program_studi.id as idProdi',  // Menggunakan idProdi
                'program_studi.namaProdi',      // Menggunakan namaProdi
                DB::raw('COUNT(ruangan.kodeRuang) as jumlahRuangan')
            )
            ->groupBy('program_studi.id', 'program_studi.namaProdi')
            ->get();
    
        // Kirim data ke view
        return view('ruang_kuliah.index', compact('daftarRuang'));
    }
    
    // Menampilkan detail ruang berdasarkan kode prodi
    public function show($idProdi)
    {
        $ruangan = DaftarRuang::join('ruangan', 'daftar_ruang.kodeRuang', '=', 'ruangan.kodeRuang')
            ->join('program_studi', 'program_studi.id', '=', 'daftar_ruang.idProdi') // Mengambil data namaProdi dari program_studi
            ->where('daftar_ruang.idProdi', $idProdi)
            ->select('ruangan.kodeRuang', 'ruangan.namaRuang', 'ruangan.kapasitas', 'daftar_ruang.jumlahRuangan', 'program_studi.namaProdi')
            ->get();
        
        return view('ruang_kuliah.detail', compact('ruangan', 'idProdi'));
    }
    
    
    // Menampilkan form untuk mengedit ruang
    public function edit($kodeRuang)
    {
        $ruangan = Ruangan::where('kodeRuang', $kodeRuang)->firstOrFail();
        $idProdi = $ruangan->daftarRuang->first()->idProdi; // Get the associated kodeProdi
        return view('ruang_kuliah.edit', compact('ruangan', 'idProdi'));
    }
    
    // Memperbarui data ruang
    public function update(Request $request, $kodeRuang)
    {
        try {
            $request->validate([
                'namaRuang' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
            ]);
    
            $ruangan = Ruangan::findOrFail($kodeRuang);
    
            $updated = $ruangan->update([
                'namaRuang' => $request->namaRuang,
                'kapasitas' => $request->kapasitas,
            ]);
    
            // Redirect ke halaman ruang-kuliah1.show
            return redirect()->route('ruang-kuliah1.show', ['idProdi' => $ruangan->daftarRuang->first()->idProdi])
                ->with('success', 'Data ruang berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data ruangan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Menghapus ruang
    public function destroy($kodeRuang)
    {
        $ruangan = Ruangan::where('kodeRuang', $kodeRuang)->firstOrFail(); // Cari berdasarkan kodeRuang
        $ruangan->delete();
    
        return redirect()->back()->with('success', 'Ruang berhasil dihapus');
    }
    
    // Menyubmit data ruang ke atasan
    public function submit($id)
    {
        $ruangan = DaftarRuang::findOrFail($id);
        // Logika pengiriman atau update status ruang
        // Misalnya mengubah status ruang menjadi 'Menunggu Persetujuan'
        
        return redirect()->route('ruang-kuliah.index')->with('success', 'Data ruang telah dikirim untuk persetujuan');
    }

    // Menampilkan form untuk membuat ruang baru
    public function create($idProdi)
    {
        // Pastikan idProdi valid
        $prodi = ProgramStudi::where('id', $idProdi)->firstOrFail();
        
        return view('ruang_kuliah.create', [
            'idProdi' => $idProdi,
            'prodi' => $prodi
        ]);
    }
    
    // Simpan ruang baru
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kodeRuang' => 'required|string|max:20|unique:ruangan,kodeRuang',
            'namaRuang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'idProdi' => 'required|exists:program_studi,id',
        ], [
            'kodeRuang.unique' => 'Ruangan sudah digunakan.',
            'kapasitas.min' => 'Kapasitas minimal 1 orang.',
        ]);
    
        // Proses penyimpanan seperti sebelumnya
        DB::transaction(function () use ($validatedData) {
            $ruangan = Ruangan::create([
                'kodeRuang' => $validatedData['kodeRuang'],
                'namaRuang' => $validatedData['namaRuang'],
                'kapasitas' => $validatedData['kapasitas'],
                'idProdi' => $validatedData['idProdi'], // Menggunakan idProdi
                'status' => false, // Default status
            ]);
    
            DaftarRuang::create([
                'idProdi' => $validatedData['idProdi'], // Menggunakan idProdi
                'kodeRuang' => $validatedData['kodeRuang'],
                'jumlahRuangan' => 1, // Default jumlah ruangan
            ]);
        });
    
        return redirect()->route('ruang-kuliah.index')
            ->with('success', 'Ruang berhasil ditambahkan.');
    }   
}