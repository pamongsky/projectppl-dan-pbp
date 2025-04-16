@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>

        <!-- Menampilkan informasi pengguna -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Informasi Pengguna</h3>
                <p><strong>NIP/NIM:</strong> {{ $user->id }}</p>
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Role:</strong> 
                    @if($user->role_id == 1)
                        Mahasiswa
                    @elseif($user->role_id == 2)
                        Pembimbing Akademik
                    @else
                        Role Tidak Dikenal
                    @endif
                </p>
            </div>
        </div>

        <!-- Kotak Mahasiswa Aktif -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Mahasiswa Aktif</h4>
                    </div>
                    <div class="card-body">
                        <h2>{{ $jumlahMahasiswaAktif }}</h2>
                    </div>
                </div>
            </div>

            <!-- Kotak IRS Disetujui -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>IRS Disetujui</h4>
                    </div>
                    <div class="card-body">
                        <h2>{{ $jumlahMahasiswaDisetujui }} / {{ $jumlahMahasiswaAktif }}</h2>
                        <p><strong>Persentase Disetujui:</strong> {{ number_format($persentaseDisetujui, 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
