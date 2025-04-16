<div class="container mt-4">
    <h3>Akademik</h3>
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
                <a href="{{ route('cetak.irs', ['semester' => $semester]) }}" class="btn btn-primary">
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

    //kode lama
</script>

