@extends('layouts.layout')

@section('title', 'Jadwal per Program Studi')
@section('header-title', 'Jadwal per Program Studi')
@section('content')
<div class="container">
    <h2>Jadwal per Program Studi</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarProdi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->namaProdi }}</td>
                    <td>
                        <a href="{{ route('dekan.DetailJadwalProdi', $item->id) }}" class="btn btn-info btn-sm">Lihat Jadwal</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
