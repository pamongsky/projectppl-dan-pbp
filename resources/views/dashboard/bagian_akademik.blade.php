@extends('layouts.layout')

@section('title', 'Dashboard Bagian Akademik')


@section('content')
    <!-- Profile Card -->
    <div class="profile-card card shadow-sm p-4 mb-4">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <div class="profile-pic" style="width: 100px; height: 100px; border-radius: 50%; background-color: #007bff; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                    <span>DB</span> <!-- Inisial nama -->
                </div>
            </div>
            <div class="col">
                <h4 class="mb-1">Dr. Bambang</h4>
                <p class="mb-0 text-muted">ID: 111223343221112</p>
                <p class="mb-0 text-muted">Email: <a href="mailto:bambang@example.com">bambang@example.com</a></p>
            </div>
        </div>

        <!-- Statistik Ruang Kuliah -->
        <div class="row">
            <div class="col-md-6">
                <div class="stat-box p-4">
                    <h5>Jumlah Ruang Kuliah</h5>
                    <p>20 Ruangan</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-box p-4">
                    <h5>Jumlah Mahasiswa</h5>
                    <p>1200 Mahasiswa</p>
                </div>
            </div>
        </div>
    </div>
@endsection
