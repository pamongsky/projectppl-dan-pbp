@php
    $uniqueProdi = $daftarRuang->unique('idProdi'); // Mengambil prodi unik berdasarkan idProdi
@endphp

@extends('layouts.layout')

@section('title', 'Daftar Ruang Kuliah')
@section('header-title', 'Daftar Ruang Kuliah')
@section('content')
<div class="container">
    <h2>Daftar Ruang Kuliah</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Program Studi</th>
                <th>Jumlah Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uniqueProdi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->namaProdi }}</td>
                    <td>{{ $item->jumlahRuangan }}</td>
                    <td>
                        <a href="{{ route('ruang-kuliah.show', $item->idProdi) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('ruang-kuliah.submit', $uniqueProdi->first()->idProdi ?? '') }}" class="btn btn-success mt-3">Kirim untuk Persetujuan</a>
</div>
@endsection
