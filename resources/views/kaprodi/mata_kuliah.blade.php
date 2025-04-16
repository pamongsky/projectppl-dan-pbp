@extends('layouts.layout')

@section('title', 'Mata Kuliah')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Mata Kuliah</h2>

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kaprodi.mata_kuliah.store') }}" method="POST" class="p-4 border rounded bg-white shadow-sm">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="namaMataKuliah" class="form-label font-weight-bold">Nama Mata Kuliah</label>
                <input type="text" id="nama_mata_kuliah" name="nama_mata_kuliah" class="form-control @error('nama_mata_kuliah') is-invalid @enderror" placeholder="Masukkan Nama Mata Kuliah" value="{{ old('nama_mata_kuliah') }}" required>
                @error('nama_mata_kuliah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="jumlahSKS" class="form-label font-weight-bold">Jumlah SKS</label>
                <input type="number" id="jumlah_sks" name="jumlah_sks" class="form-control @error('jumlah_sks') is-invalid @enderror" placeholder="Masukkan Jumlah SKS" value="{{ old('jumlah_sks') }}" required>
                @error('jumlah_sks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="kodeMataKuliah" class="form-label font-weight-bold">Kode Mata Kuliah</label>
                <input type="text" id="kode_mata_kuliah" name="kode_mata_kuliah" class="form-control @error('kode_mata_kuliah') is-invalid @enderror" placeholder="Masukkan Kode Mata Kuliah" value="{{ old('kode_mata_kuliah') }}" required>
                @error('kode_mata_kuliah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="semester" class="form-label font-weight-bold">Semester Ke-</label>
                <input type="number" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" placeholder="Masukkan Semester Ke-" value="{{ old('semester') }}" required>
                @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- <div class="row mb-4">
            <div class="col-md-6">
                <label for="dosenPengampu" class="form-label font-weight-bold">Dosen Pengampu</label>
                <input type="text" id="dosen_pengampu" name="dosen_pengampu" class="form-control @error('dosen_pengampu') is-invalid @enderror" placeholder="Masukkan Dosen Pengampu" value="{{ old('dosen_pengampu') }}" required>
                @error('dosen_pengampu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> -->
            <div class="col-md-6">
                <label for="jumlahKelas" class="form-label font-weight-bold">Jumlah Kelas</label>
                <input type="number" id="jumlah_kelas" name="jumlah_kelas" class="form-control @error('jumlah_kelas') is-invalid @enderror" placeholder="Masukkan Jumlah Kelas" value="{{ old('jumlah_kelas') }}" required>
                @error('jumlah_kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Submit Mata Kuliah
            </button>
        </div>
    </form>
</div>
@endsection
