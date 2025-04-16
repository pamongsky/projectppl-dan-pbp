@extends('layouts.layout')

@section('content')
<div class="container">
    @if($ruangan->isNotEmpty())
        <h2>Detail Ruang Program Studi: {{ $ruangan[0]->namaProdi }}</h2>

        <!-- Tabel Data Ruangan -->
        <table class="table">
            <thead>
                <tr>
                    <th>No Ruang</th>
                    <th>Nama Ruang</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangan as $item)
                    <tr>
                        <td>{{ $item->kodeRuang }}</td>
                        <td>{{ $item->namaRuang }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>{{ $item->status ? 'Disetujui' : 'Belum Disetujui' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tombol Setujui Semua dan Tolak Semua -->
        <form action="{{ route('dekan.ruangan.approveAll') }}" method="POST" class="mt-3 d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="idProdi" value="{{ $idProdi }}">
            <button type="submit" class="btn btn-success">Setujui Semua</button>
        </form>

        <form action="{{ route('dekan.ruangan.rejectAll') }}" method="POST" class="mt-3 d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="idProdi" value="{{ $idProdi }}">
            <button type="submit" class="btn btn-danger">Tolak Semua</button>
        </form>

    @else
        <p>Tidak ada data ruang untuk program studi ini.</p>
    @endif
</div>
@endsection
