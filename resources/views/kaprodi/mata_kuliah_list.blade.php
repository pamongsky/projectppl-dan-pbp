@extends('layouts.layout')

@section('title', 'Daftar Mata Kuliah')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Mata Kuliah</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Add Mata Kuliah -->
    <a href="{{ route('kaprodi.mata_kuliah.create') }}" class="btn btn-primary mb-3">Tambah Mata Kuliah</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>Jumlah SKS</th>
                <th>Semester</th>
                <th>Jumlah Kelas</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($mataKuliah as $mk)
            <tr>
                <td>{{ $mk->kode_mata_kuliah }}</td>
                <td>{{ $mk->nama_mata_kuliah }}</td>
                <td>{{ $mk->jumlah_sks }}</td>
                <td>{{ $mk->semester }}</td>
                <td>{{ $mk->jumlah_kelas }}</td>
                <td>
                    <a href="{{ route('kaprodi.mata_kuliah.edit', $mk->kode_mata_kuliah) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kaprodi.mata_kuliah.destroy', $mk->kode_mata_kuliah) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
