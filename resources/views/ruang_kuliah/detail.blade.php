@extends('layouts.layout')
@section('content')
<div class="container">
    @if($ruangan->isNotEmpty())
        <h2>Detail Ruang Program Studi: {{ $ruangan[0]->namaProdi }}</h2> <!-- Nama Prodi -->
        <table class="table">
            <thead>
                <tr>
                    <th>No Ruang</th>
                    <th>Nama Ruang</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ruangan as $item)
                    <tr>
                        <td>{{ $item->kodeRuang }}</td>
                        <td>{{ $item->namaRuang }}</td>
                        <td>{{ $item->kapasitas }}</td>
                        <td>
                            <!-- Tombol Edit Ruang -->
                            <a href="{{ route('ruang-kuliah.edit', $item->kodeRuang) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Form untuk Hapus Ruang -->
                            <form action="{{ route('ruang-kuliah.destroy', $item->kodeRuang) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data ruang untuk program studi ini.</p>
    @endif

    @php
        $kodeProdi = $idProdi ?? request()->route('idProdi'); // Menggunakan idProdi dari route
    @endphp

<a href="{{ route('ruang-kuliah.create', ['id' => $kodeProdi]) }}" class="btn btn-primary mt-3">Tambah Ruang</a>

</div>
@endsection
