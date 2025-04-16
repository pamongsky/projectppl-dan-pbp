@extends('layouts.layout')

@section('title', 'Detail')

@section('content')
    <!-- Konten Akademik -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .sks-badge {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #2ca58d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }
        .semester-header {
            cursor: pointer;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .semester-details {
            display: none;
        }
    </style>

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri: Foto dan Nama -->
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/photo_profile.png') }}" alt="Profile Photo" class="img-thumbnail mb-3" width="150">
                <h5 class="card-title">{{ $mahasiswa->namaMahasiswa }}</h5>
                <p class="text-muted"><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
            </div>

            <!-- Kolom Kanan: Informasi Mahasiswa dan Status -->
            <div class="col-md-8">
                <p><strong>Tahun Ajaran:</strong> {{ $mahasiswa->rekapIrs->tahunAjaran->nama ?? 'Ganjil 2024/2025' }}</p>
                <p><strong>Semester:</strong> {{ $mahasiswa->semester }}</p>
                <p><strong>IPK:</strong> {{ $mahasiswa->IPk }}</p>
                <p><strong>Status:</strong>
                @if ($mahasiswa->rekapIrs->status == 'disetujui')
                <span class="badge bg-success">Disetujui</span>
            @elseif ($mahasiswa->rekapIrs->status == 'tidak disetujui')
                <span class="badge bg-danger">Tidak Disetujui</span>
            @else
                <span class="badge bg-secondary">{{ $mahasiswa->rekapIrs->status }}</span>
            @endif
                </p>

                <hr>

                <!-- Fitur Update Status -->
                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'disetujui']) }}" method="POST">
                        @csrf
                        @if ($mahasiswa->rekapIrs->status == 0 || $mahasiswa->rekapIrs->status === null)
                            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                        @endif
                    </form>

                    <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'tidak']) }}" method="POST">
                        @csrf
                        @if ($mahasiswa->rekapIrs->status == 1)
                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                        @elseif ($mahasiswa->rekapIrs->status === null)
                            <button type="submit" class="btn btn-warning btn-sm">Tolak</button>
                        @endif
                    </form>

                    @if ($mahasiswa->rekapIrs->status == 1)
                        <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'belum']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">Batal</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



    <div class="container">
        <!-- Tab Navigasi untuk Halaman Akademik -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="showPage('isiIRS', this)">Isi IRS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showPage('irs', this)">Histori IRS</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#" onclick="showPage('khs', this)">KHS</a>
            </li> -->
        </ul>

        <!-- Konten Halaman Akademik -->
        <div class="page-content" id="isiIRS">
    @php
        $currentSemester = $mahasiswa->semester; // Mendapatkan semester mahasiswa saat ini
        $currentCourses = $semesterGroups[$currentSemester] ?? []; // Ambil data hanya untuk semester saat ini
    @endphp

    @if (!empty($currentCourses))
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2; text-align: left;">
                    <th>Jadwal</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>SKS</th>
                    <th>Ruang</th>
                    <th>Dosen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currentCourses as $course)
                    <tr>
                        <td>{{ $course->jadwal->hari }} {{ $course->jadwal->waktuMulai }} - {{ $course->jadwal->waktuSelesai }}</td>
                        <td>{{ $course->kode_mata_kuliah }}</td>
                        <td>{{ $course->jadwal->mataKuliah->nama_mata_kuliah }}</td>
                        <td>{{ $course->jadwal->kelas }}</td>
                        <td>{{ $course->jadwal->mataKuliah->jumlah_sks }}</td>
                        <td>{{ $course->jadwal->ruangan->kodeRuang }}</td>
                        <td>
                            @foreach ($course->dosen as $dosen)
                                {{ $dosen->namaDosen }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Data untuk semester {{ $currentSemester }} tidak tersedia.</p>
    @endif

    <hr>

    <!-- Status Update Section -->
    @if ($mahasiswa->rekapIrs->status == 'belum disetujui')
        <div class="d-flex justify-content-start gap-3 mt-3">
            <form action="{{ route('pa.validasiIrs', ['id' => $mahasiswa->nim, 'status' => 'disetujui']) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Disetujui</button>
            </form>

            <form action="{{ route('pa.validasiIrs', ['id' => $mahasiswa->nim, 'status' => 'tidak disetujui']) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Tidak Disetujui</button>
            </form>

        </div>
    @else
        <p>Status saat ini: 
            @if ($mahasiswa->rekapIrs->status == 'disetujui')
                <span class="badge bg-success">Disetujui</span>
            @elseif ($mahasiswa->rekapIrs->status == 'tidak disetujui')
                <span class="badge bg-danger">Tidak Disetujui</span>
            @else
                <span class="badge bg-secondary">{{ $mahasiswa->rekapIrs->status }}</span>
            @endif
        </p>
    @endif
</div>


            

        <div class="page-content" id="irs" style="display: none;">
            <div class="container mt-4">
                <h3>Detail Akademik {{ $mahasiswa->namaMahasiswa }}</h3>
                <div class="mt-3">
                    @foreach ($semesterGroups as $semester => $courses)
                        <div class="semester-header" onclick="toggleDetails('semester{{ $semester }}-details')">
                            <h5>Semester {{ $semester }} | Tahun Ajaran {{ $courses->first()->jadwal->tahunAjaran->namaThnAjaran }} 
                                <span class="float-end">Total SKS : {{ $courses->sum('jadwal.mataKuliah.jumlah_sks') }} <i class="fas fa-chevron-down"></i></span>
                            </h5>
                        </div>
                        <div class="semester-details" id="semester{{ $semester }}-details">
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>Jadwal</th>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>SKS</th>
                                        <th>Ruang</th>
                                        <th>Dosen</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->jadwal->hari }} {{ $course->jadwal->waktuMulai }} - {{ $course->jadwal->waktuSelesai }}</td>
                                            <td>{{ $course->kode_mata_kuliah }}</td>
                                            <td>{{ $course->jadwal->mataKuliah->nama_mata_kuliah }}</td>
                                            <td>{{ $course->jadwal->kelas }}</td>
                                            <td>{{ $course->jadwal->mataKuliah->jumlah_sks }}</td>
                                            <td>{{ $course->jadwal->ruangan->namaRuang }}</td>
                                            <td>
                                                @foreach ($course->dosen as $dosen)
                                                    {{ $dosen->namaDosen }} @if (!$loop->last), @endif
                                                @endforeach
                                            </td>
                                            <td>Baru</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="#" class="btn btn-primary" onclick="openCetakIRS('{{ $semester }}', '{{ $mahasiswa->nim }}')">
                                <i class="fas fa-print"></i> Cetak IRS
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function toggleDetails(id) {
                    var details = document.getElementById(id);
                    if (details.style.display === "none" || details.style.display === "") {
                        details.style.display = "block";
                    } else {
                        details.style.display = "none";
                    }
                }


                function openCetakIRS(semester, nim) {
                    const url = "{{ route('pa.cetakIRS', ['semester' => ':semester', 'nim' => ':nim']) }}"
                        .replace(':semester', semester)
                        .replace(':nim', nim);
                    window.open(url, '_blank');
                }

            
                //kode lama
            </script>
        </div>

        <div class="page-content" id="khs" style="display: none;">
          
        </div>
    </div>

    <script>
    function showPage(pageId, element) {
        const pages = document.querySelectorAll('.page-content');
        pages.forEach(page => {
            page.style.display = 'none';
        });
        document.getElementById(pageId).style.display = 'block';

        const tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        element.classList.add('active');
    }

    //kodelama
</script>

@endsection