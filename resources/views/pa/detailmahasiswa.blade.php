@extends('layouts.layout')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container">
<div class="card">
    <div class="card-body">
        <!-- Foto Mahasiswa -->
        <img src="{{ asset('images/photo_profile.png') }}" alt="Profile Photo" class="img-thumbnail" width="150">

        <h5 class="card-title">{{ $mahasiswa->namaMahasiswa }}</h5>
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>

        <hr>

        <p><strong>Tahun Ajaran:</strong> {{ $mahasiswa->rekapIrs->tahunAjaran->nama ?? 'Tahun Ajaran Tidak Ditemukan' }}</p>
        <p><strong>Semester:</strong> {{ $mahasiswa->rekapIrs->semester }}</p>
        <p><strong>IPK:</strong> {{ $mahasiswa->IPk }}</p>
        
        <!-- Status Mahasiswa -->
        <p><strong>Status:</strong>
            @if ($mahasiswa->rekapIrs->status == 0)
                <span class="text-danger">Tidak Disetujui</span>
            @elseif ($mahasiswa->rekapIrs->status == 1)
                <span class="text-success">Sudah Disetujui</span>
            @else
                <span class="text-warning">Belum Disetujui</span>
            @endif
        </p>

        <hr>

        <!-- Fitur Update Status -->
        <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'disetujui']) }}" method="POST">
            @csrf
            @if ($mahasiswa->rekapIrs->status == 0 || $mahasiswa->rekapIrs->status === null)
                <button type="submit" class="btn btn-success">Setujui</button>
            @endif
        </form>
        
        <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'tidak']) }}" method="POST">
            @csrf
            @if ($mahasiswa->rekapIrs->status == 1)
                <button type="submit" class="btn btn-danger">Tolak</button>
            @elseif ($mahasiswa->rekapIrs->status === null)
                <button type="submit" class="btn btn-warning">Tolak</button>
            @endif
        </form>

        <!-- Tombol Batal untuk Setujui Mahasiswa -->
        @if ($mahasiswa->rekapIrs->status == 1)
            <form action="{{ route('pa.updateStatus', ['id' => $mahasiswa->nim, 'status' => 'belum']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning">Batal</button>
            </form>
        @endif
    </div>
</div>
@endsection
