@extends('layouts.layout')

@section('title', 'Detail Jadwal Program Studi')
@section('header-title', 'Detail Jadwal Program Studi')

@section('content')
<div class="container">
    @if($jadwal->isNotEmpty())
        <h2>Detail Jadwal Program Studi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Kuota</th>
                    <th>Kapasitas Ruang</th>
                    <th>Ruang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwal as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kode_mata_kuliah }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ $item->waktuMulai }}</td>
                        <td>{{ $item->waktuSelesai }}</td>
                        <td>{{ $item->kuota }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>{{ $item->kodeRuang }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada jadwal yang disetujui untuk program studi ini.</p>
    @endif
</div>
@endsection
