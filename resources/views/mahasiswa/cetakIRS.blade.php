<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak IRS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            font-size: 13px;
        }
        h3, h5 {
            text-align: left;
            font-size: 13px;
        }

        .header-text {
            text-align: center;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }

        .signature-section {
            margin-top: 20px;
        }
        .signature-section div {
            display: inline-block;
            width: 45%;
            vertical-align: top;
        }
        .signature-section div:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-text">
            <p>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</p>
            <p>FAKULTAS SAINS DAN MATEMATIKA</p>
            <p>UNIVERSITAS DIPONEGORO</p>
            <p>ISIAN RENCANA STUDI</p>
            <p>Semester Ganjil TA 2024/2025</p>
    </div>
    <h5>Nama Mahasiswa: {{ $mahasiswa->namaMahasiswa }}</h5>

    @foreach ($semesterGroups as $semester => $courses)
        <h5>Semester {{ $semester }} | Tahun Ajaran {{ $courses->first()->jadwal->tahunAjaran->namaThnAjaran }}</h5>
        <table>
            <thead>
                <tr>
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
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->jadwal->hari }} {{ $course->jadwal->waktuMulai }} - {{ $course->jadwal->waktuSelesai }}</td>
                        <td>{{ $course->kode_mata_kuliah }}</td>
                        <td>{{ $course->jadwal->mataKuliah->nama_mata_kuliah }}</td>
                        <td>{{ $course->jadwal->kelas }}</td>
                        <td>{{ $course->jadwal->mataKuliah->jumlah_sks }}</td>
                        <td>{{ $course->jadwal->ruangan->kodeRuang }}</td>
                        <td>
                            @foreach ($course->dosen as $dosen)
                                {{ $dosen->namaDosen }} @if (!$loop->last), @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="signature-section">
            <div>
                <p></p>
                <p></p>
                <p>Pembimbing Akademik (Dosen Wali)</p>
                <p></p>
                <p></p>
                <p>Dr. Sutikno, S.T., M.Cs.<br/>NIP. {{ $mahasiswa->NIPWali }}</p>
            </div>
            <div>
                <p>Semarang, 18 Desember 2024</p>
                <p>Nama Mahasiswa,</p>
                <p></p>
                <p></p>
                <p>{{ $mahasiswa->namaMahasiswa }}<br/>NIM. {{ $mahasiswa->nim }}</p>
            </div>
        </div>
</body>
</html>
