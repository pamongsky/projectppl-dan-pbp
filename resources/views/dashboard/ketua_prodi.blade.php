@extends('layouts.layout')

@section('title', 'Dashboard Kaprodi')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Statistik atau Ringkasan -->
    <div class="row">
        <!-- Jumlah Mahasiswa -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Mahasiswa</h5>
                    <h2 class="card-text">{{ $jumlahMahasiswa }}</h2>
                    <a href="{{ route('kaprodi.mahasiswa') }}" class="btn btn-primary btn-sm mt-2">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Jumlah Mata Kuliah -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Mata Kuliah</h5>
                    <h2 class="card-text">{{ $jumlahMataKuliah }}</h2>
                    <a href="{{ route('kaprodi.mata_kuliah') }}" class="btn btn-primary btn-sm mt-2">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Jadwal Kuliah -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Jadwal Kuliah</h5>
                    <h2 class="card-text">{{ $jumlahJadwalKuliah }}</h2>
                    <a href="{{ route('kaprodi.jadwal_kuliah') }}" class="btn btn-primary btn-sm mt-2">Lihat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi atau Pengumuman -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Pengumuman
        </div>
        <div class="card-body">
            <p>Tidak ada pengumuman baru saat ini.</p>
        </div>
    </div>
</div>
@endsection
