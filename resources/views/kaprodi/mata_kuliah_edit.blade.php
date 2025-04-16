@extends('layouts.layout')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Mata Kuliah</h2>

    <!-- error kalau ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kaprodi.mata_kuliah.update', $mataKuliah->kode_mata_kuliah) }}" method="POST" class="p-4 border rounded bg-white shadow-sm">
        @csrf
        @method('PUT')  {{-- Gunakan PUT untuk update --}}
        
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="namaMataKuliah" class="form-label font-weight-bold">Nama Mata Kuliah</label>
                <input type="text" id="namaMataKuliah" name="nama_mata_kuliah" class="form-control @error('nama_mata_kuliah') is-invalid @enderror" value="{{ old('nama_mata_kuliah', $mataKuliah->nama_mata_kuliah) }}">
                @error('nama_mata_kuliah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="jumlahSKS" class="form-label font-weight-bold">Jumlah SKS</label>
                <input type="number" id="jumlahSKS" name="jumlah_sks" class="form-control @error('jumlah_sks') is-invalid @enderror" value="{{ old('jumlah_sks', $mataKuliah->jumlah_sks) }}" min="1" max="6">
                @error('jumlah_sks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="kodeMataKuliah" class="form-label font-weight-bold">Kode Mata Kuliah</label>
                <input type="text" id="kodeMataKuliah" name="kode_mata_kuliah" class="form-control" value="{{ $mataKuliah->kode_mata_kuliah }}">
            </div>
            <div class="col-md-6">
                <label for="semester" class="form-label font-weight-bold">Semester Ke-</label>
                <input type="number" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $mataKuliah->semester) }}" min="1" max="8">
                @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <!-- <div class="col-md-6">
                <label for="dosenPengampu" class="form-label font-weight-bold">Dosen Pengampu</label>
                <input type="text" id="dosenPengampu" name="dosen_pengampu" class="form-control @error('dosen_pengampu') is-invalid @enderror" value="{{ old('dosen_pengampu', $mataKuliah->dosen_pengampu) }}">
                @error('dosen_pengampu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> -->
            <div class="col-md-6">
                <label for="jumlahKelas" class="form-label font-weight-bold">Jumlah Kelas</label>
                <input type="number" id="jumlahKelas" name="jumlah_kelas" class="form-control @error('jumlah_kelas') is-invalid @enderror" value="{{ old('jumlah_kelas', $mataKuliah->jumlah_kelas) }}" min="1" max="10">
                @error('jumlah_kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-pencil"></i> Update Mata Kuliah
            </button>
        </div>
    </form>
</div>
@endsection
