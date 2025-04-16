@extends('layouts.layout')
@section('title', 'Dashboard Mahasiswa')
@section('content')

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <div class="profile-pic"></div>  <!-- Gambar profile dapat ditambahkan di sini -->
            </div>
            <div class="col">
                <h4>{{ $mahasiswa->namaMahasiswa }}</h4>
                <p class="mb-0">
                    {{ $mahasiswa->nim }} | 
                    {{ $mahasiswa->prodi ? $mahasiswa->prodi->namaProdi : 'Program Studi tidak tersedia' }}
                </p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-6">
                <div class="stat-box">
                    <h5>IP</h5>
                    <h3>{{ $mahasiswa->IPk ?? '-' }}</h3>  <!-- Tampilkan IP jika ada -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-box">
                    <h5>SKS</h5>
                    <h3>72</h3>  <!-- Kamu bisa menyesuaikan dengan jumlah SKS yang sebenarnya -->
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Status -->
    <div class="announcement-section mb-4">
        <h4><i class="bi bi-building"></i> Status Akademik</h4>
        <p class="text-muted">Informasi lebih lanjut dapat menghubungi dosen wali Anda.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <p class="mb-1">Dosen Wali:</p>
                <h6>{{ $mahasiswa->wali ? $mahasiswa->wali->namaDosen : 'Data dosen wali tidak tersedia' }}</h6>
                <p class="text-muted">(NIP: {{ $mahasiswa->wali ? $mahasiswa->wali->nip : 'Data NIP tidak tersedia' }})</p>
            </div>
            <div class="col-md-4">
                <p class="mb-1">Semester Akademik Sekarang:</p>
                <h6>{{ date('Y') }}/{{ date('Y') + 1 }} Ganjil</h6> <!-- Atur sesuai dengan data semester akademik -->
                <p class="mb-1">Semester Studi:</p>
                <h6>{{ $mahasiswa->semester }}</h6>
            </div>
            <div class="col-md-4">
                <p class="mb-1">Status Akademik:</p>
                <span class="status-badge {{ $mahasiswa->status }}">
                    {{ ucfirst(str_replace('_', ' ', $mahasiswa->status)) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Announcement -->
    @if ($mahasiswa->status === 'belum_dipilih')
        <div class="announcement-section">
            <h4>Announcement</h4>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-circle"></i>
                Anda belum melakukan registrasi. Silakan pilih status akademik Anda.
            </div>
        </div>
    @endif

@endsection
