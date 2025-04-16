@extends('layouts.layout')

@section('title', 'Penyusunan Jadwal Kuliah')

@section('content')
    <div class="container">
        <h1>Daftar Jadwal Kuliah</h1>
        <!-- Label "Tambah Jadwal" -->
        <a href="{{ route('kaprodi.jadwal_kuliah') }}" class="btn btn-primary mb-3">
            Tambah Jadwal
        </a>
        
        <!-- Filter Tahun Ajaran -->
        <form action="{{ route('kaprodi.jadwal_list') }}" method="GET" class="mb-4">
            <div class="form-group">
                <label for="tahun_ajaran">Pilih Tahun Ajaran:</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Tahun Ajaran --</option>
                    @foreach ($tahunAjarans as $tahun)
                        <option value="{{ $tahun->id }}" {{ $tahun->id == $tahunAjaran ? 'selected' : '' }}>
                            {{ $tahun->namaThnAjaran }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Tabel Jadwal -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Kelas</th>
                    <th>Ruangan</th>
                    <th>Kuota</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $index => $jadwal)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jadwal->mataKuliah->nama_mata_kuliah }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->waktuMulai }} - {{ $jadwal->waktuSelesai }}</td>
                        <td>{{ $jadwal->kelas }}</td>
                        <td>{{ $jadwal->ruangan-> namaRuang}}</td>
                        <td>{{ $jadwal->kuota }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada jadwal yang tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection