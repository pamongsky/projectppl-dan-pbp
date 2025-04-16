<?php

namespace App\Http\Controllers;

use App\Models\DosenPengampu;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;



class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tahun ajaran jika ada
        $tahunAjaran = $request->input('tahun_ajaran');
        
        // Ambil data jadwal yang sesuai dengan tahun ajaran
        $jadwals = Jadwal::with('mataKuliah', 'ruangan', 'tahunAjaran')
            ->when($tahunAjaran, function ($query) use ($tahunAjaran) {
                return $query->where('idThnAjaran', $tahunAjaran);
            })
            ->orderBy('hari', 'asc')
            ->orderBy('waktuMulai', 'asc')
            ->get();

        // Ambil data tahun ajaran untuk filter dropdown
        $tahunAjarans = TahunAjaran::all();

        return view('kaprodi.jadwal_list', compact('jadwals', 'tahunAjarans', 'tahunAjaran'));
    }

    public function dashboard()
    {
        // Mengambil jumlah mahasiswa dari tabel mahasiswa
        $jumlahMahasiswa = Mahasiswa::count();
        
        // Mengambil jumlah mata kuliah dari tabel mata_kuliah
        $jumlahMataKuliah = MataKuliah::count();
        
        // Mengambil jumlah jadwal kuliah dari tabel jadwal_kuliah
        $jumlahJadwalKuliah = Jadwal::count();

        // Mengirim data ke view dashboard
        return view('dashboard.ketua_prodi', compact('jumlahMahasiswa', 'jumlahMataKuliah', 'jumlahJadwalKuliah'));
    }


    public function simpanDosenPengampu(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'mata_kuliah' => 'required|exists:mata_kuliah,kode_mata_kuliah',
            'nip_dosen' => 'required|exists:dosen,nip',
        ]);
    
        try {
            // Simpan data menggunakan Eloquent create()
            DosenPengampu::create([
                'kode_mata_kuliah' => $validated['mata_kuliah'],
                'nip_dosen' => $validated['nip_dosen'],
            ]);
    
            // Berikan feedback sukses
            return redirect()->route('kaprodi.jadwal_kuliah')->with('success', 'Dosen Pengampu berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error jika ada
            return redirect()->route('kaprodi.jadwal_kuliah')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'mata_kuliah' => 'required|exists:mata_kuliah,kode_mata_kuliah',
            'hari' => 'required|string',
            'waktu_mulai' => 'required|date_format:H:i',
            'kelas' => 'required|string|max:1',
            'ruangan' => 'required|exists:ruangan,kodeRuang',
            'kuota' => 'required|integer|min:0',
        ]);

        try {
            // Ambil data mata kuliah untuk menghitung waktu selesai
            $mataKuliah = MataKuliah::find($validated['mata_kuliah']);
            
            if (!$mataKuliah) {
                return redirect()->route('kaprodi.jadwal_kuliah')->with('error', 'Mata kuliah tidak ditemukan');
            }

            // Hitung waktu selesai berdasarkan jumlah SKS
            $waktuMulai = \Carbon\Carbon::createFromFormat('H:i', $validated['waktu_mulai']);
            $waktuSelesai = $waktuMulai->addMinutes($mataKuliah->jumlah_sks * 50); // 50 menit per SKS

            // Cek apakah kuota melebihi kapasitas ruangan
            $ruangan = Ruangan::find($validated['ruangan']);
            if ($validated['kuota'] > $ruangan->kapasitas) {
                return redirect()->back()->with('error', 'Kuota melebihi kapasitas ruangan!');
            }

            // Jadwal bentrok dengan jadwal yang sudah ada
            $existingSchedules = Jadwal::where('hari', $validated['hari'])
                ->where('kodeRuang', $validated['ruangan'])
                ->where(function($query) use ($waktuMulai, $waktuSelesai) {
                    $query->where(function($subQuery) use ($waktuMulai, $waktuSelesai) {
                        // Cek waktu bertabrakan
                        $subQuery->where('waktuMulai', '<', $waktuSelesai)
                                ->where('waktuSelesai', '>', $waktuMulai);
                    });
                })
                ->exists();

            if ($existingSchedules) {
                return redirect()->back()->with('error', 'Jadwal tidak dapat ditambahkan karena bentrok!');
            }

            // Cek apakah kombinasi mata kuliah dan kelas sudah ada
            $existingScheduleWithSameClass = Jadwal::where('kode_mata_kuliah', $validated['mata_kuliah'])
                ->where('kelas', $validated['kelas'])
                ->exists();

            if ($existingScheduleWithSameClass) {
                return redirect()->back()->with('error', 'Kombinasi mata kuliah dan kelas sudah ada!');
            }

            // Simpan jadwal ke database
            Jadwal::create([
                'idThnAjaran' => $validated['tahun_ajaran'],
                'kode_mata_kuliah' => $validated['mata_kuliah'],
                'hari' => $validated['hari'],
                'waktuMulai' => $validated['waktu_mulai'],
                'waktuSelesai' => $waktuSelesai->format('H:i'),  // Format waktu selesai
                'kelas' => $validated['kelas'],
                'kodeRuang' => $validated['ruangan'],
                'kuota' => $validated['kuota'],
                'status' => false,  // Default status is false
            ]);

            return redirect()->route('kaprodi.jadwal_kuliah')->with('success', 'Jadwal Kuliah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('kaprodi.jadwal_kuliah')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function getJadwalByTahunAjaran($tahunAjaranId)
    {
        // Mengambil data jadwal berdasarkan tahun ajaran
        $jadwals = Jadwal::where('idThnAjaran', $tahunAjaranId)
                        ->with(['mataKuliah', 'ruangan']) // Pastikan relasi dimuat jika diperlukan
                        ->get();

        // Format data agar sesuai dengan tampilan yang diinginkan
        $result = $jadwals->map(function($jadwal) {
            return [
                'mata_kuliah' => $jadwal->mataKuliah->nama_mata_kuliah,
                'hari' => $jadwal->hari,
                'waktuMulai' => $jadwal->waktuMulai,
                'waktuSelesai' => $jadwal->waktuSelesai,
                'kelas' => $jadwal->kelas,
                'ruangan' => $jadwal->ruangan->namaRuang,
                'kuota' => $jadwal->kuota
            ];
        });

        // Mengembalikan data dalam format JSON
        return response()->json($result);
    }

    // Fungsi untuk mendapatkan jadwal berdasarkan mata kuliah
    public function getMataKuliahJadwal(Request $request)
    {
        $mataKuliah = MataKuliah::where('nama_mata_kuliah', 'like', '%' . $request->q . '%')->first();
    
        if (!$mataKuliah) {
            return response()->json(['message' => 'Mata kuliah tidak ditemukan'], 404);
        }
    
        // Ambil jadwal berdasarkan kode mata kuliah
        $jadwal = Jadwal::where('kode_mata_kuliah', $mataKuliah->kode_mata_kuliah)->get();
        return response()->json([
            'mata_kuliah' => $mataKuliah,
            'jadwal' => $jadwal,
        ]);
    }
}
