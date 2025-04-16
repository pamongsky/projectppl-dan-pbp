<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return view('kaprodi.mata_kuliah_list', compact('mataKuliah'));
    }

    public function storeMataKuliah(Request $request)
    {
        $request->validate([
            'kode_mata_kuliah' => 'required|string|max:20|unique:mata_kuliah,kode_mata_kuliah',
            'nama_mata_kuliah' => 'required|string|max:255|unique:mata_kuliah,nama_mata_kuliah',
            'jumlah_sks' => 'required|integer|between:1,6',
            'semester' => 'required|integer|between:1,8',
            'jumlah_kelas' => 'required|integer|between:1,10',
        // 'dosen_pengampu' => 'required|string|max:50',
    ], [
        'kode_mata_kuliah.required' => 'Kode Mata Kuliah harus diisi.',
        'kode_mata_kuliah.max' => 'Kode Mata Kuliah tidak boleh lebih dari 25 karakter.',
        'kode_mata_kuliah.unique' => 'Kode Mata Kuliah ini sudah terdaftar.',
        'nama_mata_kuliah.required' => 'Nama Mata Kuliah harus diisi.',
        'nama_mata_kuliah.max' => 'Nama Mata Kuliah tidak boleh lebih dari 50 karakter.',
        'nama_mata_kuliah.unique' => 'Nama Mata Kuliah ini sudah terdaftar.',
        'jumlah_sks.required' => 'Jumlah SKS harus diisi.',
        'jumlah_sks.between' => 'Jumlah SKS harus antara 1 hingga 6.',
        'semester.required' => 'Semester harus diisi.',
        'semester.between' => 'Semester harus antara 1 hingga 8.',
        'jumlah_kelas.required' => 'Jumlah Kelas harus diisi.',
        'jumlah_kelas.between' => 'Jumlah Kelas harus antara 1 hingga 10.',
        // 'dosen_pengampu.required' => 'Nama Dosen Pengampu harus diisi.',
        // 'dosen_pengampu.max' => 'Nama Dosen Pengampu tidak boleh lebih dari 50 karakter.',
    ]);
        
        MataKuliah::create([
        'kode_mata_kuliah' => $request->kode_mata_kuliah,
        'nama_mata_kuliah' => $request->nama_mata_kuliah,
        'jumlah_sks' => $request->jumlah_sks,
        'semester' => $request->semester,
        'jumlah_kelas' => $request->jumlah_kelas,
    ]);
        return redirect()->route('kaprodi.mata_kuliah')->with('success', 'Mata kuliah berhasil disimpan.');
    }

    public function createMataKuliah()
    {
        return view('kaprodi.mata_kuliah');
    }

    public function list()
    {
        $mataKuliah = MataKuliah::all();
        return view('kaprodi.mata_kuliah_list', compact('mataKuliah'));
    }

    // app/Http/Controllers/KaprodiController.php

    public function editMataKuliah($kode_mata_kuliah)
    {
        $mataKuliah = MataKuliah::where('kode_mata_kuliah', $kode_mata_kuliah)->first();
    
        if (!$mataKuliah) {
            return redirect()->route('kaprodi.mata_kuliah')->withErrors('Mata kuliah tidak ditemukan.'); // ini strip
        }

        return view('kaprodi.mata_kuliah_edit', compact('mataKuliah'));
    }

    public function updateMataKuliah(Request $request, $kode_mata_kuliah)
    {
        $request->validate([
            'kode_mata_kuliah' => 'required|string|max:20|unique:mata_kuliah,kode_mata_kuliah,' . $kode_mata_kuliah . ',kode_mata_kuliah',
            'nama_mata_kuliah' => 'required|string|max:255|unique:mata_kuliah,nama_mata_kuliah,' . $kode_mata_kuliah . ',kode_mata_kuliah',
            'jumlah_sks' => 'required|integer|between:1,6',
            'semester' => 'required|integer|between:1,8',
            'jumlah_kelas' => 'required|integer|between:1,10',
       ]);

        $mataKuliah = MataKuliah::where('kode_mata_kuliah', $kode_mata_kuliah)->first();

        if (!$mataKuliah) {
            return redirect()->route('kaprodi.mata_kuliah')->withErrors('Mata kuliah tidak ditemukan.');
        }

        // Update data mata kuliah
        $mataKuliah->update([
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'jumlah_sks' => $request->jumlah_sks,
            'semester' => $request->semester,
            'jumlah_kelas' => $request->jumlah_kelas,
        ]);

        return redirect()->route('kaprodi.mata_kuliah')->with('success', 'Mata kuliah berhasil diperbarui.');
    }


    // Menghapus mata kuliah
    public function destroy($kode_mata_kuliah)
    {
        $mataKuliah = MataKuliah::findOrFail($kode_mata_kuliah);
        if (!$mataKuliah) {
            return redirect()->route('kaprodi.mata_kuliah')->with('error', 'Mata kuliah tidak ditemukan.');
        }
    
        $mataKuliah->delete();

        return redirect()->route('kaprodi.mata_kuliah')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    //untuk mahasiswa

     // Menampilkan mata kuliah yang tersedia untuk dicari
     public function search(Request $request)
     {
         $query = $request->input('q');
         $mataKuliah = MataKuliah::where('nama_mata_kuliah', 'like', "%{$query}%")
             ->orWhere('kode_mata_kuliah', 'like', "%{$query}%")
             ->whereHas('jadwal', function ($q) {
                $q->where('idThnAjaran', 1);
            })
             ->get();

        \Log::info(DB::getQueryLog());
 
             
         // Pastikan jadwal dimuat untuk setiap mata kuliah
         foreach ($mataKuliah as $mk) {
             $mk->jadwal = Jadwal::where('kode_mata_kuliah', $mk->kode_mata_kuliah)->get();
         }
 
         // Mengembalikan data mata kuliah dengan jadwal
         return response()->json($mataKuliah);
     }
 
     // Menambahkan mata kuliah yang dipilih ke IRS dan menampilkan jadwal
     public function addToSelectedList(Request $request)
     {
         // Ambil mata kuliah dari input request
         $mataKuliah = MataKuliah::find($request->kode_mata_kuliah);
 
         // Ambil jadwal yang terhubung dengan mata kuliah yang dipilih
         $jadwals = Jadwal::where('kode_mata_kuliah', $mataKuliah->kode_mata_kuliah)->get();
 
         // Menyimpan data ke session atau database IRS
         session()->push('selected_courses', $mataKuliah);
         session()->push('jadwals', $jadwals);
 
        return back();
    }

}
